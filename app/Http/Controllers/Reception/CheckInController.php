<?php

namespace App\Http\Controllers\Reception;

use App\CheckIn;
use App\Http\Controllers\Controller;
use App\IndividualReservationRoom;
use App\Meal;
use App\Registration;
use App\Reservation;
use App\ReservationCheckInDetail;
use App\ReservationGroup;
use App\ReservationGroupCheckInDetail;
use App\Room;
use App\RoomSurcharge;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class CheckInController extends Controller
{   
    //! INDIVIDUAL
    /**
     * 
     * Individual Reservation
     */
    public $id;
    
    public function index()
    {
        return view('frontOffice.reception.individualCheckIn.index');
    }

    public function dataTableIndividualReservation()
    {
        $individualReservation = Reservation::where('status', 'confirm')->latest()->get();
        return datatables()->of($individualReservation)
            ->addColumn('action', function ($individualReservation) {
                $btn = '<a href="/reception/detailIndividualCheckIn/' . $individualReservation->id . '" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function detailIndividualReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $difference = $this->getDifference($id);
        $rooms = Room::all();
        $standart = \collect($this->getRoomsPartials()['standart']);
        $superior = \collect($this->getRoomsPartials()['superior']);
        $deluxe = \collect($this->getRoomsPartials()['deluxe']);

        $individialReservationRoomWhereNotExtraBad = IndividualReservationRoom::select('id', 'typeOfRoom', 'totalRoomReserved', 'roomRate')->where('reservation_id', $id)->whereNotIn('typeOfRoom', ['extraBad'])->get();

        $extraBad = DB::table('individual_reservation_rooms')
                ->where('typeOfRoom', '=', 'extraBad')
                ->where('reservation_id', '=' ,$id)
                ->first();
        
        return view('frontOffice.reception.individualCheckIn.detailIndividualReservation', \compact('reservation', 'rooms', 'difference', 'individialReservationRoomWhereNotExtraBad', 'extraBad', 'standart', 'superior', 'deluxe'));
    }

    public function getDifference($id)
    {
        $reservation = Reservation::findOrFail($id);
        $checkIn = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        return $difference;
    }

    //! GROUP
    /**
     * 
     * GROUP FUNCTION
     */
    public function indexGroup()
    {
        return view('frontOffice.reception.groupCheckIn.index');
    }

    public function dataTableGroupReservation()
    {
        $GroupReservation = ReservationGroup::where('status', 'confirm')->latest()->get();
        return datatables()->of($GroupReservation)
            ->addColumn('action', function ($GroupReservation) {
                $btn = '<a href="/reception/detailGroupCheckIn/' . $GroupReservation->id . '" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function detailGroupReservation($id)
    {
        $reservationGroup = ReservationGroup::findOrfail($id);
        $checkIn = new Carbon($reservationGroup->arrivaleDate);
        $checkOut = $reservationGroup->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);


        return \view('frontOffice.reception.groupCheckIn.detailGroupReservation', [
            'groupReservation' => $reservationGroup,
            'difference' => $difference,
            'meals' => Meal::get(),
            'rooms' => Room::all(),
            'standart' => \collect($this->getRoomsPartials()['standart']),
            'superior' => \collect($this->getRoomsPartials()['superior']),
            'deluxe' => \collect($this->getRoomsPartials()['deluxe'])
        ]);
    }

    //! Other Function
    public function crateRoomSurCharge($id)
    {
        $registration = Registration::find($id);
        $jamSekarang = Carbon::now()->toTimeString();
        $jamDuaSiang = Carbon::parse('14:00');
        $diffInHours = $jamSekarang < $jamDuaSiang ? $jamDuaSiang->diffInHours($jamSekarang) : \null;
        $roomSurCharge = [];
        foreach($registration->rooms as $room){
            $roomSurCharge[] = [
                'registration_id' => $registration->id,
                'typeRoom' => $room->roomType,
                'roomSurCharge' => $diffInHours*25000,
                'typeSurCharge' => 'early C/I',
            ];
        }
        return $diffInHours == '' ? \null : RoomSurcharge::insert($roomSurCharge) ;
    }

    public function checkIn($id)
    {
        $check = Registration::where('id', $id)->first();
        if ($check->status == 'checkIn') {
            $success = true;
            $message = 'Guest has checked in';
        } else {
            $regis = Registration::find($id);
            $regis->update(['status' => 'checkIn']);

            /**
             * jika checkIn tamu By reservation
             */
            //cek reservation individual
            $reservation = ReservationCheckInDetail::where('registration_id', $id)->first();
            // cek group individual
            $groupReservation = ReservationGroupCheckInDetail::where('registration_id', $id)->first();

            if ($reservation != '') {

                $reservation->reservation->update(['status' => 'checkIn']);
                //update status individual_reservation_rooms
                DB::table('individual_reservation_rooms')->whereIn('reservation_id', [$reservation->reservation_id])
                ->update(['status' => 2]);
            } elseif ($groupReservation != ''){

                $groupReservation->reservationGroup->update(['status' => 'checkIn']);
                DB::table('group_reservation_rooms')->whereIn(
                    'reservationgroup_id', [$groupReservation->reservationgroup_id]
                )->update(['status' => 2]);
            } else {

                $success = false;
                $message = 'Error! reservation individual or group not found!!!';
            }
            $this->crateRoomSurCharge($id);
            CheckIn::create([
                'registration_id' => $id,
                'time' => Carbon::now()->toTimeString(),
                'date' => Carbon::now()->isoFormat('D-M-Y'),
            ]);

            $success = false;
            $message = 'Check in is saved';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function checkEarlyArrivale($id)
    {   
        $jamSekarang = Carbon::now()->toTimeString();
        $jamDuaSiang = Carbon::parse('14:00');
        $diffInHours = $jamSekarang < $jamDuaSiang ? $jamDuaSiang->diffInHours($jamSekarang) : \null;
        // jika check in melebihi jam 2 siang maka akan di kenakan biaya tambahan
        if ($jamSekarang > $jamDuaSiang) {
            return $this->checkIn($id); //jika tidak lanjut ke check in
        } else {
            //jika melebihi di kenakan charge
            $success = \false;
            $message = 'Guests will be charged an additional fee, because check-in is before 2pm !';
        }
        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function cekRoom(Request $request)
    {   
        if($this->checkDuplicateRooms($request)){
            $success = true;
            $message = 'There are duplicate rooms';
        }else if ($this->checkRoomStandart($request) == \true) {
            $success = true;
            $message = 'The room STANDART booked exceeds the available rooms';
        } elseif($this->checkRoomSuperior($request) == \true) {
            $success = true;
            $message = 'The room SUPERIOR booked exceeds the available rooms';
        } elseif($this->checkRoomDeluxe($request) == \true){
            $success = true;
            $message = 'The room DELUXE booked exceeds the available rooms';
        } else {
            $success = \false;
            $message = 'sip';
        }
        return \response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    public function checkDuplicateRooms(Request $request)
    {   
        $cek = (\count($request->roomArragement) !== \count(\array_unique($request->roomArragement))) ? true : \false;
        return $cek;
    }

    public function checkRoomStandart(Request $request)
    {   
        $rooms = $request->rooms;
        $rooms = \is_array($rooms) ? $rooms : [$rooms];
        //cek kamar
        $countRoom = Room::whereIn('id', $rooms)->pluck('roomType');
        
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
        
        //rumus semua kamar booking
        $totalRoomReservedStandart = $individuReservedStandart + $groupReservationStandart;

        //cek kamar VR
        $roomStandartVR = Room::where([
            ['roomType', '=', 'standart'],
            ['code' ,'=', 'VR']
        ])->get();

        $countRequestStandart = \collect($countRoom)->filter(function($countRequestStandart){
            return $countRequestStandart == "STANDART";
        });

        $totalRoomStandart = count($roomStandartVR) - $totalRoomReservedStandart;

        // jika request lebih besar dari rumus (jumlah room VR - total room yang di booking)
        if ($countRequestStandart->count() > $totalRoomStandart) {
            $success = true;
            $message = 'The room STANDART booked exceeds the available rooms';
        } else {
            $success = \false;
        }

        return $success;
    }

    public function checkRoomSuperior(Request $request)
    {   
        $rooms = $request->rooms;
        $rooms = \is_array($rooms) ? $rooms : [$rooms];
        //cek kamar
        $countRoom = Room::whereIn('id', $rooms)->pluck('roomType');
        

        //jumlah room yang di booking individu
        $individuReservedSuperior = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        //jumlah room yang di booking group
        $groupReservationSuperior = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'superior'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        
        $totalRoomReserveSuperior = $individuReservedSuperior + $groupReservationSuperior;

        $roomSuperiorVR = Room::where([
            ['roomType', '=', 'superior'],
            ['code' ,'=', 'VR']
        ])->get();

        $countRequestRoomSuperior = \collect($countRoom)->filter(function($countRequestRoomSuperior){
            return $countRequestRoomSuperior == "SUPERIOR";
        });

        $totalRoomSuperior = \count($roomSuperiorVR) - $totalRoomReserveSuperior;

        // jika request lebih besar dari rumus (jumlah room VR - total room yang di booking)
        if ($countRequestRoomSuperior->count() > $totalRoomSuperior) {
            $success = true;
            $message = 'The room SUPERIOR booked exceeds the available rooms';
        } else {
            $success = \false;
        }

        return $success;
    }

    public function checkRoomDeluxe(Request $request)
    {   
        $rooms = $request->rooms;
        $rooms = \is_array($rooms) ? $rooms : [$rooms];
        //cek kamar
        $countRoom = Room::whereIn('id', $rooms)->pluck('roomType');
        
        //jumlah room yang di booking individu
        $individuReservedDeluxe = DB::table('individual_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');

        //jumlah room yang di booking group
        $groupReservationDeluxe = DB::table('group_reservation_rooms')->where([
            ['typeOfRoom', '=', 'deluxe'],
            ['status', '=', 1]
        ])->sum('totalRoomReserved');
        
        $totalRoomReservedDeluxe = $individuReservedDeluxe + $groupReservationDeluxe;

        $roomDeluxeVR = Room::where([
            ['roomType', '=', 'deluxe'],
            ['code' ,'=', 'VR']
        ])->get();

        $countRequestRoomDeluxe = \collect($countRoom)->filter(function($countRequestRoomDeluxe){
            return $countRequestRoomDeluxe == "DELUXE";
        });

        $totalRoomDeluxe = \count($roomDeluxeVR) - $totalRoomReservedDeluxe;

        // jika request lebih besar dari rumus (jumlah room VR - total room yang di booking)
        if ($countRequestRoomDeluxe->count() > $totalRoomDeluxe) {
            $success = true;
            $message = 'The room DELUXE booked exceeds the available rooms';
        } else {
            $success = \false;
        }

        return $success;
    }

    public function getRoomsPartials()
    {
        $standart = Room::where([
            ['roomType', '=', 'STANDART'],
            ['code', '=', 'VR']
        ])->get();

        $superior = Room::where([
            ['roomType', '=', 'SUPERIOR'],
            ['code', '=', 'VR']
        ])->get();

        $deluxe = Room::where([
            ['roomType', '=', 'DELUXE'],
            ['code', '=', 'VR']
        ])->get();

        return [
            'standart' => $standart,
            'superior' => $superior,
            'deluxe' => $deluxe
        ];
    }

    public function test()
    {
        $standart = $this->getRoomsPartials()['standart'];
        foreach($standart as $key => $v){
            $data[] = $v->code;
        }

        \dd($data);
    }
}
