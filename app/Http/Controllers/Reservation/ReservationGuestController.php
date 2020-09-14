<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationFormRequest;
use App\Reservation;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // ReservationFormRequest
        $rooms = Room::find($request->rooms);
        $rooms->toQuery()->update(['status' => 'O']);

        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($request->arrivaleDate);
        $checkOut = $request->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < 1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $total = $difference*=$rooms->sum('price');

        //total price
        // $rooms->sum('price');

        // clear!!!
        $rooms->toQuery()->update(['status' => 'O']);
        $data = \array_merge($request->except('_token', 'rooms'), \compact('total'));
        $reservation = Reservation::create($data);
        $reservation->rooms()->attach($rooms);
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
        $reservation = Reservation::with('rooms',)->find($id);
        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        
        return view('frontOffice.reservation.detail', \compact('reservation','difference'));
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
    public function update(ReservationFormRequest $request, Reservation $reservation)
    {
        $data = $request->except('_token', 'numberRoom');
        $reservation->update($data);

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

    public function deleteRoom(Request $request, $id, Reservation $reservation)
    {
        $room = Room::find($request->idRoom);
        $reservation = Reservation::find($id);

        $checkin = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $selisih = ($checkin->diff($checkOut)->days < -1) ? 'today' : $checkin->diffInDays($checkOut);
        $total = $reservation->total - ($room->price * $selisih);
        $room->update(['status' => 'VR']);
        $reservation->update(['total' => $total]);
        $room->reservations()->detach($id);
        return \redirect()->back();
    }

    public function addNewRoom(Request $request, $id)
    {
        $rooms = Room::find($request->rooms);
        $reservation = Reservation::find($id);
        //mengambil selisih hari. antara checkin dan checkout
        $checkIn = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);

        $total = ($difference * $rooms->sum('price') + $reservation->total);

        $rooms->toQuery()->update(['status' => 'O']);
        $reservation->update(['total'=> $total]);
        $reservation->rooms()->attach($rooms);
        return \redirect()->back();
    }
}
