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

class CheckRoomAvailableController extends Controller
{
    public function checkRoomStandart(Request $request)
    {   
        //jumlah room yang di booking individu
        $individuReservedStandart = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        //jumlah room yang di booking group
        $groupReservationStandart = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        
        $totalRoomReservedStandart = $individuReservedStandart + $groupReservationStandart;

        $roomStandartVR = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VR']
        ])->get();

        // jika request lebih besar dari rumus (jumlah room VR - total room yang di booking)
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

        $individuReservedSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $groupReservationSuperior = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $totalRoomReservedSuperior = $individuReservedSuperior + $groupReservationSuperior;

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
        $roomDeluxeVR = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VR']
        ])->get();

        $individuReservedDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $groupReservationDeluxe = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $totalRoomReservedDeluxe = $individuReservedDeluxe + $groupReservationDeluxe;

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
        $individuReservedStandart = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $groupReservationStandart = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        
        $totalRoomReservedStandart = $individuReservedStandart + $groupReservationStandart;

        $roomStandartVR = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VR']
        ])->get();

        //SUPERIOR
        $roomSuperiorVR = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VR']
        ])->get();

        $individuReservedSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $groupReservationSuperior = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $totalRoomReservedSuperior = $individuReservedSuperior + $groupReservationSuperior;

        //DELUXE
        $roomDeluxeVR = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VR']
        ])->get();

        $individuReservedDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $groupReservationDeluxe = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $totalRoomReservedDeluxe = $individuReservedDeluxe + $groupReservationDeluxe;

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
