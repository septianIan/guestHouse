<?php

namespace App\Http\Controllers\Chart;

use App\CheckOut;
use App\Http\Controllers\Controller;
use App\IndividualReservationRoom;
use App\MasterBill;
use App\MethodPayment;
use App\Registration;
use App\Reservation;
use App\ReservationGroup;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchedulerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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

    public function individuReservedStandart()
    {
        $individuReservedStandart = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        return $individuReservedStandart;
    }

    public function groupReservationStandart()
    {
        $groupReservationStandart = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'standart'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        return $groupReservationStandart;
    }

    public function individuReservedSuperior()
    {
        $individuReservedSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        return $individuReservedSuperior;
    }

    public function groupReservationSuperior()
    {
        $groupReservationSuperior = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        return $groupReservationSuperior;
    }

    public function individuReservedDeluxe()
    {
        $individuReservedDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        return $individuReservedDeluxe;
    }

    public function groupReservationDeluxe()
    {
        $groupReservationDeluxe = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        return $groupReservationDeluxe;
    }

    /**
     * Status = 0 tamu sudah checkOut atau sudah selesai
     * Status = 1 tamu booking
     * Status = 2 tamu sudah checkIn
     */
    public function roomArragement()
    {   
        //all rooms
        $rooms = $this->getRoomAll();
        //standart
        $roomStandart = $this->getRoomStandart();
        $roomStandartVR = $this->getRoomStandartVR();
        $roomStandartVD = $this->getRoomStandartVD();
        $roomStandartVC = $this->getRoomStandartVC();
        $roomStandartO = $this->getRoomStandartO();
        
        $totalBookingRoomReservedStandart = $this->individuReservedStandart() + $this->groupReservationStandart();
        
        //superior
        $roomSuperior = $this->getRoomSuperior();
        $roomSuperiorVR = $this->getRoomSuperiorVR();
        $roomSuperiorVD = $this->getRoomSuperiorVD();
        $roomSuperiorVC = $this->getRoomSuperiorVC();
        $roomSuperiorO = $this->getRoomSuperiorO();
        $totalRoomReservedSuperior = $this->individuReservedSuperior() + $this->groupReservationSuperior();

        //deluxe
        $roomDeluxe = $this->getRoomDeluxe();
        $roomDeluxeVR = $this->getRoomDeluxeVR();
        $roomDeluxeVD = $this->getRoomDeluxeVD();
        $roomDeluxeVC = $this->getRoomDeluxeVC();
        $roomDeluxeO = $this->getRoomDeluxeO();
        $totalRoomReservedDeluxe = $this->individuReservedDeluxe() + $this->groupReservationDeluxe();

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
        
        $guestIndividualReservations = DB::table('reservations')->orderBy('estimateArrivale', 'asc')
        ->get();

        $guestGroupReservation = DB::table('reservationgroups')->orderBy('estimateArrivale', 'asc')
        ->get();

        $data = [];
        foreach($guestIndividualReservations as $key => $v){
            $data[] = [
                'guestName' => $v->guestName,
                'estimateArrivale' => $v->estimateArrivale,
                'contactPerson' => $v->contactPerson,
                'arrivaleDate' => $v->arrivaleDate,
                'departureDate' => $v->departureDate,
                'address' => $v->address,
            ];
        }

        $dataGroup = [];
        foreach($guestGroupReservation as $key => $v){
            $dataGroup[] = [
                'guestName' => $v->groupName,
                'estimateArrivale' => $v->estimateArrivale,
                'contactPerson' => $v->contactPerson,
                'departureDate' => $v->departureDate,
                'arrivaleDate' => $v->arrivaleDate,
                'address' => $v->addressPerson,
            ];
        }

        $merged = \array_merge($data, $dataGroup);
        return \collect($merged)->sortBy('estimateArrivale');
    }

    public function todayEAList()
    {   
        return view('frontOffice.fitur.todayArrivale');
    }

    public function dtTodayEA()
    {   
        $arrivalDate = $this->getArrivaleReservation();
        return \datatables()->of($arrivalDate)
        ->addColumn('arrivaleDate', function($arrivalDate){
            if ($arrivalDate['arrivaleDate'] < Carbon::now()->format('Y-m-d')) {
                $data = '<font style="color:red;font-weight:bold;">'.$arrivalDate['arrivaleDate'].'</font>';
            } else {
                $data = '<font style="font-weight:bold;">'.$arrivalDate['arrivaleDate'].'</font>';
            }
            return $data;
        })
        ->addIndexColumn()
        ->rawColumns(['arrivaleDate'])
        ->toJson();
    }

    //*DEPARTURE date
    //?DEPARTURE date
    //!DEPARTURE date

    public function dtTodayED()
    {
        $departureDate = $this->getArrivaleReservation();
        return \datatables()->of($departureDate)
        ->addColumn('departureDate', function($departureDate){
            if (Carbon::now()->format('Y-m-d') < $departureDate['departureDate']) {
                $data = '<font style="font-weight:bold;">'.$departureDate['departureDate'].'</font>';
            } else {
                $data = '<font style="color:red;font-weight:bold;">'.$departureDate['departureDate'].'</font>';
            }

            return $data;
        })
        ->addIndexColumn()
        ->rawColumns(['departureDate'])
        ->toJson();
    }

    public function todayEDList()
    {   
        return view('frontOffice.fitur.todayDeparture');
    }

    public function schedulerCalendar()
    {   
        return view('frontOffice.fitur.calendar');
    }

    public function cashierSummaryCalendar()
    {   
        return view('frontOffice.fitur.cashierSummary');
    }

    public function cekRoom($date)
    {   
        // if ($this->registration($date)->isEmpty()) {
        //     return \abort(404);
        // }
        // cari tamu yang akan check out di tanggal $date status nya check in,
        $totalBookingRoomReservedStandart = $this->individuReservedStandart() + $this->groupReservationStandart();
        $standartRoomAvailable = count($this->getRoomStandartVR())-$totalBookingRoomReservedStandart;

        $totalRoomReservedSuperior = $this->individuReservedSuperior() + $this->groupReservationSuperior();
        $superiorRoomAvaileble = count($this->getRoomSuperiorVR())-$totalRoomReservedSuperior;

        $totalRoomReservedDeluxe = $this->individuReservedDeluxe() + $this->groupReservationDeluxe();
        $deluxeRoomAvaileble = count($this->getRoomDeluxeVR())- $totalRoomReservedDeluxe;
        
        $countRoom = [];
        foreach($this->registration($date) as $regis){
            foreach($regis->rooms as $room){
                $countRoom[] = $room->id;
            }
        }
        return view('frontOffice.fitur.detailCalendar.checkRoom', [
            'registration' => $this->registration($date),
            'roomAvailble' =>  \count($countRoom) + $standartRoomAvailable + $superiorRoomAvaileble + $deluxeRoomAvaileble,
            'standartRoomAvailable' => $standartRoomAvailable,
            'superiorRoomAvaileble' => $superiorRoomAvaileble,
            'deluxeRoomAvaileble' => $deluxeRoomAvaileble,
            'dateSelected' => $date,
            'standartRoom' => $this->getRoomStandartVR(),
            'superiorRoom' => $this->getRoomSuperiorVR(),
            'deluxeRoom' => $this->getRoomDeluxeVR(),
        ]);
    }

    public function registration($date)
    {   
        $guestRegistration = Registration::whereDate('departureDate', '<=', $date)
        ->where('status', 'checkIn')->get();

        return $guestRegistration;
    }

    public function cashierSummry($date)
    {
        /**
         * Ambil semua pemasukan pada tanggal ini,
         * 1. pemasukan deposit tamu indiviudal dan group
         * 2. pemasukan tamu check out
         * 3. semua metode pembayaran
         */

        $depositReservationIndividu = $this->getIndividualReservations($date);
        $depostiGroupReservation = $this->getGroupReservations($date);
        $getCheckOutPayment = $this->getCheckOutPayment($date);
        $getOnlyTrasherd = $this->getOnlyTrasherd($date);

        $deposit1 = [];
        foreach($depositReservationIndividu as $depositIndividu){
            $deposit1[] = [
                'methodPayment' => $depositIndividu->methodPayment,
                'income' => $depositIndividu->deposit
            ]; 
        }

        $deposit2 = [];
        foreach($depostiGroupReservation as $depositGroup){
            $deposit2[] = [
                'methodPayment' => $depositGroup->methodPayment,
                'income' => $depositGroup->deposit
            ]; 
        }

        $masterBIll = [];
        foreach($getCheckOutPayment as $mBill){
            $masterBIll[] = [
                'methodPayment' => $mBill->methodPayment,
                'income' => $mBill->detailMasterBills()->sum('charge')
            ];
        }

        $merge = \array_merge($deposit1, $deposit2, $masterBIll, $getOnlyTrasherd);
        $total = [];
        foreach($merge as $v){
            $total[] = $v['income'];
        }
        
        return view('frontOffice.fitur.detailCalendar.FoCashierSummary', [
            'date' => $date,
            'income' => $merge,
            'total' => \array_sum($total)
        ]);

    }

    public function getIndividualReservations($date)
    {   
        //ambil dari tgl reservasi
        $depositReservationIndividu = Reservation::where([
            ['arrivaleDate', '=', $date],
            ['clerk', '=', auth()->user()->name]
        ])->get();
        return $depositReservationIndividu;
    }

    public function getGroupReservations($date)
    {
        // ambil deposti yang metode pembayaran personal
        // 'reservationgroup_id' => $groupReservation->id,
        // 'methodPayment' => $request->methodPayment,
        // 'deposit' => $request->deposit,
        // 'value1' => $request->creditCard,
        // 'value2' => $request->numberAccount,
        // 'value3' => $requestOther,
        // 'status' => 0
        $groupReservation = ReservationGroup::where([
            ['arrivaleDate', $date],
            ['clerk', '=', auth()->user()->name]
        ])->get();

        $idGroup = [];
        foreach($groupReservation as $id){
            $idGroup[] = $id->id;
        }

        $depositGroupReservation = [];
        $depositGroupReservation = MethodPayment::where([
            ['reservationgroup_id', '=', $idGroup],
            ['methodPayment', '=', 'company']
        ])->get();

        return $depositGroupReservation;
    }

    public function getCheckOutPayment($date)
    {
        $checkOut = CheckOut::where([
            ['date', '=', $date]
        ])->get();

        $registrationId = [];
        foreach($checkOut as $co){
            $registrationId[] = $co->registration_id;
        }

        $masterBill = MasterBill::whereIn('registration_id', $registrationId)->get();
        
        return $masterBill;
    }

    public function getOnlyTrasherd($date)
    {
        $reser = Reservation::onlyTrashed()->where([
            ['arrivaleDate', $date],
            ['clerk', '=', auth()->user()->name]
        ])->get();

        $reserGroup = ReservationGroup::onlyTrashed()->where([
            ['arrivaleDate', $date],
            ['clerk', '=', auth()->user()->name]
        ])->get();

        $idGroup = [];
        foreach($reserGroup as $id){
            $idGroup[] = $id->id;
        }

        $depositGroupReservation = [];
        $depositGroupReservation = MethodPayment::where([
            ['reservationgroup_id', '=', $idGroup],
            ['methodPayment', '=', 'company']
        ])->get();

        $indiOnlyTrahed = [];
        foreach($depositGroupReservation as $depositGroup){
            $indiOnlyTrahed[] = [
                'methodPayment' => $depositGroup->methodPayment,
                'income' => $depositGroup->deposit
            ]; 
        }

        $groupOnlyTrahed = [];
        foreach($reser as $depositIndividu){
            $groupOnlyTrahed[] = [
                'methodPayment' => $depositIndividu->methodPayment,
                'income' => $depositIndividu->deposit
            ]; 
        }

        $merge = \array_merge($indiOnlyTrahed, $groupOnlyTrahed);
        return $merge;
    }
}
