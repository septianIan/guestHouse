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
    public function store(Request $request)
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
                if ($request->rooms[$room] != '' && $request->totalRoomReserved[$room]  != '') {
                    $individualReservationDetail = [
                        'reservation_id' => $reservation->id,
                        'totalRoomReserved' => $request->totalRoomReserved[$room],
                        'typeOfRoom' => $request->rooms[$room],
                        'roomRate' => $request->roomRate[$room],
                        'discount' => $request->discount[$room]
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
    public function update(Request $request, Reservation $reservation)
    {
        // \dd($request->all());
        $data = $request->except('_token', 'numberRoom', 'totalRoomReserved', 'rooms', 'idRooms', 'roomRate', 'discount');
        $reservation->update($data);

        //ROOM ARRAGEMENT
        for ($i = 0; $i < \count(array($request->idRooms)); $i++) {
            DB::table('individual_reservation_rooms')->where('id', $request->idRooms[$i])
                ->update([
                    'reservation_id' => $reservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$i],
                    'typeOfRoom' => $request->rooms[$i],
                    'roomRate' => $request->roomRate[$i],
                    'discount' => $request->discount[$i]
                ]);
        }
        //jika ada tambahan kamar
        // jika request room lebih besar dari pada data kamar sebelumnya, maka ada tambahan kamar
        if (\count($request->rooms) > \count($reservation->individualReservationRooms)) {
            foreach ($request->rooms as $room => $v) {
                $individualReservationDetail = [
                    'reservation_id' => $reservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$room],
                    'typeOfRoom' => $request->rooms[$room],
                    'roomRate' => $request->roomRate[$room],
                    'discount' => $request->discount[$room]
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

    /**
     * Jquery
     */

    public function searchRoomRate(Request $request)
    {
        $roomRate = DB::table('rooms')->where('roomType', $request->typeRoom)->first();
        return \response()->json([
            // 'success' => $success,
            // 'message' => $message,
            'room' => $roomRate,
        ]);
    }

    public function checkRoomStandart(Request $request)
    {
        $totalRoomReservedStandart = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $roomStandartVR = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VR']
        ])->get();

        if ($request->totalRoomReserved > \count($roomStandartVR) - $totalRoomReservedStandart) {
            $success = true;
            $message = 'The room STANDART booked exceeds the available rooms';
        } else {
            $success = \false;
            $message = $request->totalRoomReserved.' Rooms standart available';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function checkRoomSuperior(Request $request)
    {
        $roomSuperiorVR = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VR']
        ])->get();
        $totalRoomReservedSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        if ($request->totalRoomReserved > \count($roomSuperiorVR) - $totalRoomReservedSuperior) {
            $success = true;
            $message = 'The room SUPERIOR booked exceeds the available rooms';
        } else {
            $success = \false;
            $message = $request->totalRoomReserved.' Rooms superior available';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function checkRoomDeluxe(Request $request)
    {
        $totalRoomReservedDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $roomDeluxeVR = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VR']
        ])->get();

        if ($request->totalRoomReserved > count($roomDeluxeVR) - $totalRoomReservedDeluxe) {
            $success = true;
            $message = 'The room DELUXE booked exceeds the available rooms';
        } else {
            $success = \false;
            $message = $request->totalRoomReserved.' Rooms deluxe available';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function checkAvailableRoom(Request $request)
    {
        //STANDART
        $totalRoomReservedStandart = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $roomStandartVR = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VR']
        ])->get();

        //SUPERIOR
        $roomSuperiorVR = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VR']
        ])->get();
        $totalRoomReservedSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        //DELUXE
        $totalRoomReservedDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $roomDeluxeVR = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VR']
        ])->get();

        if($request->typeRoom == 'standart'){

            if ($request->totalRoomReserved > \count($roomStandartVR) - $totalRoomReservedStandart) {
                $success = true;
                $message = 'The room STANDART booked exceeds the available rooms';
            } else {
                $success = \false;
                $message = $request->totalRoomReserved.' Rooms standart available';
            }
        } elseif($request->typeRoom == 'superior'){

            if ($request->totalRoomReserved > \count($roomSuperiorVR) - $totalRoomReservedSuperior) {
                $success = true;
                $message = 'The room SUPERIOR booked exceeds the available rooms';
            } else {
                $success = \false;
                $message = $request->totalRoomReserved.' Rooms superior available';
            }

        } elseif($request->typeRoom == 'deluxe'){
            
            if ($request->totalRoomReserved > count($roomDeluxeVR) - $totalRoomReservedDeluxe) {
                $success = true;
                $message = 'The room DELUXE booked exceeds the available rooms';
            } else {
                $success = \false;
                $message = $request->totalRoomReserved.' Rooms deluxe available';
            }

        } else {
            $success = \false;
            $message = 'Total room reserved or type room is not blank';
        }


        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
