<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use App\IndividualReservationRoom;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchedulerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rooms()
    {
        $rooms = Room::all();
        
        $result = array();
        foreach($rooms as $room){
            $r = new Room();
            $r->id = $room['id'];
            $r->name = $room['numberRoom'];
            $r->capacity = intval($room['capacity']);
            $r->status = $room['code'];
            $result[] = $r;
        }

        return \response()->json($result);
    }

    public function getRoomAll()
    {
        $rooms = Room::all();
        return $rooms;
    }

    public function reservationPlan()
    {
        $rooms = $this->getRoomAll();
        //standart
        $roomStandart = Room::where('roomType', 'standart')->get();
        $roomStandartVR = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VR']
        ])->get();
        $roomStandartVD = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VD']
        ])->get();
        $roomStandartVC = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VC']
        ])->get();
        $roomStandartO = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'O']
        ])->get();
        $bookingStandart = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        
        //superior
        $roomSuperior = Room::where('roomType', 'superior')->get();
        $roomSuperiorVR = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VR']
        ])->get();
        $roomSuperiorVD = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VD']
        ])->get();
        $roomSuperiorVC = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VC']
        ])->get();
        $roomSuperiorO = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'O']
        ])->get();
        $bookingSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        //deluxe
        $roomDeluxe = Room::where('roomType', 'deluxe')->get();
        $roomDeluxeVR = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VR']
        ])->get();
        $roomDeluxeVD = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VD']
        ])->get();
        $roomDeluxeVC = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VC']
        ])->get();
        $roomDeluxeO = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'O']
        ])->get();

        $bookingDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        return view('frontOffice.reservation.chartPlan.reservationPlanIndex', \compact('rooms', 
            //
            'roomStandart', 
            'roomStandartVR', 
            'roomStandartVD', 
            'roomStandartVC', 
            'roomStandartO',
            'bookingStandart',
            // 
            'roomSuperior', 
            'roomSuperiorVR', 
            'roomSuperiorVD', 
            'roomSuperiorVC', 
            'roomSuperiorO', 
            'bookingSuperior',
            //
            'roomDeluxe',
            'roomDeluxeVR',
            'roomDeluxeVD',
            'roomDeluxeVC',
            'roomDeluxeO',
            'bookingDeluxe'
        ));
    }
}
