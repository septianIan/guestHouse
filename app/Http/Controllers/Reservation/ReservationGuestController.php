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
        $roomRateStandart = Room::where('roomType', 'standart')->first();
        $roomRateSuperior = Room::where('roomType', 'superior')->first();
        $roomRateDeluxe = Room::where('roomType', 'deluxe')->first();
        return view('frontOffice.reservation.create',  \compact('rooms', 'roomRateStandart', 'roomRateSuperior', 'roomRateDeluxe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    //ReservationFormRequest
    public function store(ReservationFormRequest $request)
    {
        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($request->arrivaleDate);
        $checkOut = $request->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < 1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $data = \array_merge($request->except('_token', 'rooms', 'totalRoomReserved', 'roomRate', 'discount'));
        $reservation = Reservation::create($data);

        //menyimpan pengaturan kamar reservasi
        if (\count($request->rooms) > 0) {
            foreach ($request->rooms as $room => $v) {
                //jika req room ada dan req totalRoomReserved ada, maka true
                if ($request->totalRoomReserved[$room]  != ''&& $request->rooms[$room] != '') {
                    $individualReservationDetail = [
                        'reservation_id' => $reservation->id,
                        'totalRoomReserved' => $request->totalRoomReserved[$room],
                        'typeOfRoom' => $request->rooms[$room],
                        'roomRate' => $request->roomRate[$room],
                    ];
                    DB::table('individual_reservation_rooms')->insert($individualReservationDetail);
                }
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
        return view('frontOffice.reservation.detail', \compact('reservation'));
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
    public function update(ReservationFormRequest $request, Reservation $reservation)
    {
        // \dd($request->all());
        $data = $request->except('_token', 'numberRoom', 'totalRoomReserved', 'rooms', 'idRooms', 'roomRate', 'discount');
        $reservation->update($data);

        //jika ada tambahan kamar
        // jika request room lebih besar dari pada data kamar sebelumnya, maka ada tambahan kamar
        if (\count($request->rooms) > \count($reservation->individualReservationRooms)) {
            foreach ($request->rooms as $room => $v) {
                if ($request->rooms[$room] != '') {
                    $individualReservationDetail = [
                        'reservation_id' => $reservation->id,
                        'totalRoomReserved' => $request->totalRoomReserved[$room],
                        'typeOfRoom' => $request->rooms[$room],
                        'roomRate' => $request->roomRate[$room],
                    ];
                    IndividualReservationRoom::updateOrCreate([
                        'reservation_id' => $reservation->id,
                        'typeOfRoom' => $request->rooms[$room]
                    ],$individualReservationDetail);
                }
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
        if ($reservation->status == 'checkIn') {
            $success = true;
            $message = 'Guest has chacked in, data cannot be deleted';
        } else {
            $reservation->update(['status' => 0]);
            $reservation->delete();

            $success = false;
            $message = 'Data has been deleted';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message
        ]);
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
