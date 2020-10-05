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
        // $rooms = Room::find($request->rooms);

        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($request->arrivaleDate);
        $checkOut = $request->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < 1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $data = \array_merge($request->except('_token', 'rooms', 'totalRoomReserved'));
        $reservation = Reservation::create($data);

        if (\count($request->rooms) > 0) {
            foreach ($request->rooms as $room => $v) {
                $individualReservationDetail = [
                    'reservation_id' => $reservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$room],
                    'typeOfRoom' => $request->rooms[$room]
                ];
                DB::table('individual_reservation_rooms')->insert($individualReservationDetail);
            }
        }

        // di pakai nanti ketika check in
        // $rooms->toQuery()->update(['code' => 'O']);
        // $reservation->rooms()->attach($rooms);
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
        $reservation = Reservation::with('rooms')->findOrFail($id);
        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);

        return view('frontOffice.reservation.detail', \compact('reservation', 'difference'));
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
        $roomReser = DB::table('reservation_room')
            ->where('reservation_id', $id)
            ->first();
        $rooms = Room::all();
        return view('frontOffice.reservation.edit', \compact('reservation', 'rooms', 'roomReser'));
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
        $data = $request->except('_token', 'numberRoom', 'totalRoomReserved', 'rooms');
        $reservation->update($data);

        if (\count($request->rooms) > 0) {
            foreach ($request->rooms as $room => $v) {
                $individualReservationDetail = [
                    'reservation_id' => $reservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$room],
                    'typeOfRoom' => $request->rooms[$room]
                ];
                $data = IndividualReservationRoom::firstOrCreate($individualReservationDetail);
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
        $reservation->rooms()->update(['status' => 'VR']);
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
