<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationFormRequest;
use App\IndividualReservationRoom;
use App\Reservation;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ReservationGuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontOffice.reservation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::all();
        return view('frontOffice.reservation.create',  \compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationFormRequest $request)
    {
        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($request->arrivaleDate);
        $checkOut = $request->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < 1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $data = \array_merge($request->except('_token', 'rooms', 'totalRoomReserved', 'roomRate'));
        $reservation = Reservation::create($data);

        if (\count($request->rooms) > 0) {
            foreach ($request->rooms as $room => $v) {
                $individualReservationDetail = [
                    'reservation_id' => $reservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$room],
                    'typeOfRoom' => $request->rooms[$room],
                    'roomRate' => $request->roomRate[$room]
                ];
                DB::table('individual_reservation_rooms')->insert($individualReservationDetail);
            }
        }
        
        \session()->flash('message', 'Reservation has been added');
        return \redirect()->route('reservation.reservation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $totalRate = $reservation->individualReservationRooms()->sum('roomRate') * $difference;

        $individualReservationRoom = DB::table('individual_reservation_rooms')
                                ->where('reservation_id', $reservation->id)
                                ->get();

        $total = 0;
        foreach($individualReservationRoom as $value){
            $total += $value->roomRate * $value->totalRoomReserved * $difference;
        }

        return view('frontOffice.reservation.detail', \compact('reservation', 'difference', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reservation = Reservation::find($id);
        $rooms = Room::all();
        $extraBad = DB::table('individual_reservation_rooms')
                ->where('typeOfRoom', '=', 'extraBad')
                ->where('reservation_id', '=' ,$id)
                ->first();
        return view('frontOffice.reservation.edit', \compact('reservation', 'rooms', 'extraBad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        // \dd($request->all());
        $data = $request->except('_token', 'numberRoom', 'totalRoomReserved', 'rooms', 'idRooms', 'roomRate');
        $reservation->update($data);

        //ROOM ARRAGEMENT
        for ($i = 0; $i < \count($request->idRooms); $i++) {
            DB::table('individual_reservation_rooms')->where('id', $request->idRooms[$i])
                ->update([
                    'reservation_id' => $reservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$i],
                    'typeOfRoom' => $request->rooms[$i],
                    'roomRate' => $request->roomRate[$i]
                ]);
        }
        //jika ada tambahan kamar
        if (\count($request->rooms) > \count($reservation->individualReservationRooms)) {
            foreach ($request->rooms as $room => $v) {
                $individualReservationDetail = [
                    'reservation_id' => $reservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$room],
                    'typeOfRoom' => $request->rooms[$room],
                    'roomRate' => $request->roomRate[$room]
                ];
                IndividualReservationRoom::updateOrCreate($individualReservationDetail, [
                    'reservation_id' => $reservation->id
                ]);
            }
        }
        \session()->flash('message', 'Reservation has been changed');
        return \redirect()->route('reservation.reservation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->update(['status' => 0]);
        $reservation->delete();
        return \response()->json(['sukses' => true]);
    }

    public function cancelGuest()
    {
        return view('frontOffice.reservation.cancelGuestView');
    }

    public function detailCancelReservation($id)
    {
        $reservation = Reservation::onlyTrashed()
            ->with('rooms')
            ->where('id', $id)->first();
        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);

        return view('frontOffice.reservation.detail', \compact('reservation', 'difference'));
    }

    public function deleteRoomArragement($id)
    {
        $individualReservationDetail = IndividualReservationRoom::find($id);
        $individualReservationDetail->delete();
        return \redirect()->back();
    }
}
