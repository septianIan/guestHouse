<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use App\IndividualReservationRoom;
use App\Reservation;
use App\ReservationGroup;
use App\Room;
use Carbon\Carbon;
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

    public function getRoomStandart()
    {
        $roomStandart = Room::where('roomType', 'standart')->get();
        return $roomStandart;
    }

    public function getRoomStandartVR()
    {
        $roomStandartVR = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VR']
        ])->get();
        return $roomStandartVR;
    }

    public function getRoomStandartVD()
    {
        $roomStandartVD = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VD']
        ])->get();
        return $roomStandartVD;
    }

    public function getRoomStandartVC()
    {
        $roomStandartVC = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VC']
        ])->get();
        return $roomStandartVC;
    }

    public function getRoomStandartO()
    {
        $roomStandartO = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'O']
        ])->get();
        return $roomStandartO;
    }

    public function getRoomSuperior()
    {
        $roomSuperior = Room::where('roomType', 'superior')->get();
        return $roomSuperior;
    }

    public function getRoomSuperiorVR()
    {
        $roomSuperiorVR = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VR']
        ])->get();
        return $roomSuperiorVR;
    }

    public function getRoomSuperiorVD()
    {
        $roomSuperiorVD = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VD']
        ])->get();
        return $roomSuperiorVD;
    }

    public function getRoomSuperiorVC()
    {
        $roomSuperiorVC = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'VC']
        ])->get();
        return $roomSuperiorVC;
    }

    public function getRoomSuperiorO()
    {
        $roomSuperiorO = Room::where([
            ['roomType', '=', 'superior'],
            ['code', '=', 'O']
        ])->get();
        return $roomSuperiorO;
    }

    public function getRoomDeluxe()
    {
        $roomDeluxe = Room::where('roomType', 'deluxe')->get();
        return $roomDeluxe;
    }

    public function getRoomDeluxeVR()
    {
        $roomDeluxeVR = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VR']
        ])->get();
        return $roomDeluxeVR;
    }

    public function getRoomDeluxeVD()
    {
        $roomDeluxeVD = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VD']
        ])->get();
        return $roomDeluxeVD;
    }

    public function getRoomDeluxeVC()
    {
        $roomDeluxeVC = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'VC']
        ])->get();
        return $roomDeluxeVC;
    }

    public function getRoomDeluxeO()
    {
        $roomDeluxeO = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code', '=', 'O']
        ])->get();
        return $roomDeluxeO;
    }

    public function reservationPlan()
    {   
        //all rooms
        $rooms = $this->getRoomAll();
        //standart
        $roomStandart = $this->getRoomStandart();
        $roomStandartVR = $this->getRoomStandartVR();
        $roomStandartVD = $this->getRoomStandartVD();
        $roomStandartVC = $this->getRoomStandartVC();
        $roomStandartO = $this->getRoomStandartO();
        $individuReservedStandart = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        $groupReservationStandart = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved'); 
        $totalBookingRoomReservedStandart = $individuReservedStandart + $groupReservationStandart;
        
        //superior
        $roomSuperior = $this->getRoomSuperior();
        $roomSuperiorVR = $this->getRoomSuperiorVR();
        $roomSuperiorVD = $this->getRoomSuperiorVD();
        $roomSuperiorVC = $this->getRoomSuperiorVC();
        $roomSuperiorO = $this->getRoomSuperiorO();
        $individuReservedSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        $groupReservationSuperior = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        $totalRoomReservedSuperior = $individuReservedSuperior + $groupReservationSuperior;

        //deluxe
        $roomDeluxe = $this->getRoomDeluxe();
        $roomDeluxeVR = $this->getRoomDeluxeVR();
        $roomDeluxeVD = $this->getRoomDeluxeVD();
        $roomDeluxeVC = $this->getRoomDeluxeVC();
        $roomDeluxeO = $this->getRoomDeluxeO();

        $individuReservedDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $groupReservationDeluxe = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        $totalRoomReservedDeluxe = $individuReservedDeluxe + $groupReservationDeluxe;

        return view('frontOffice.fitur.reservationPlanIndex', \compact('rooms', 
            //
            'roomStandart', 
            'roomStandartVR', 
            'roomStandartVD', 
            'roomStandartVC', 
            'roomStandartO',
            'totalBookingRoomReservedStandart',
            // 
            'roomSuperior', 
            'roomSuperiorVR', 
            'roomSuperiorVD', 
            'roomSuperiorVC', 
            'roomSuperiorO', 
            'totalRoomReservedSuperior',
            //
            'roomDeluxe',
            'roomDeluxeVR',
            'roomDeluxeVD',
            'roomDeluxeVC',
            'roomDeluxeO',
            'totalRoomReservedDeluxe'
        ));
    }

    public function getArrivaleReservation()
    {
        $dateToday = Carbon::today()->format('Y-m-d');
        
        $guestIndividualReservations = Reservation::where('arrivaleDate', $dateToday)
        ->orderBy('estimateArrivale', 'asc')
        ->get();

        $guestGroupReservation = ReservationGroup::where('arrivaleDate', $dateToday)
        ->orderBy('estimateArrivale', 'asc')
        ->get();

        foreach($guestIndividualReservations as $key => $v){
            $data[] = [
                'guestName' => $v->guestName,
                'estimateArrivale' => $v->estimateArrivale,
                'contactPerson' => $v->contactPerson,
                'departureDate' => $v->departureDate,
                'address' => $v->address,
            ];
        }

        foreach($guestGroupReservation as $key => $v){
            $dataGroup[] = [
                'guestName' => $v->groupName,
                'estimateArrivale' => $v->estimateArrivale,
                'contactPerson' => $v->contactPerson,
                'departureDate' => $v->departureDate,
                'address' => $v->addressPerson,
            ];
        }

        $merged = \array_merge($data, $dataGroup);
        return \collect($merged)->sortBy('estimateArrivale');
    }

    public function todayArrivalList()
    {
        return view('frontOffice.fitur.todayArrivale', [
            'arrivalReservation' => $this->getArrivaleReservation()
        ]);
    }
}
