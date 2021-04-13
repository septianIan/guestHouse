<?php

namespace App\Http\Controllers\Reception;

use App\CheckIn;
use App\ExtraBad;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationFormRequest;
use App\Registration;
use App\Reservation;
use App\ReservationCheckInDetail;
use App\ReservationGroupCheckInDetail;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CheckOut;
use App\RoomSurcharge;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontOffice.reception.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::get();
        return \view('frontOffice.reception.create', \compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationFormRequest $request)
    {   
        //\dd($request->all());
        $data = \array_merge($request->except('_token', 'roomNo', 'totalPax', 'roomRate', 'typeOfRegistration', 'walkInOrReservation', 'rooms', 'idIndividualReservation', 'idGroupReservation', 'amount', 'extraBad', 'rate', 'idRooms', 'meals', 'timeMeal'));
        $registration = Registration::create($data);

        $registration_id = $registration->id;
        if ($request->has('extraBad')) {
            $extraBadData = \array_merge($request->only('amount', 'extraBad', 'rate'), \compact('registration_id'));
            ExtraBad::create($extraBadData);
        }
        
        // update kamar O (occupation)
        $rooms = Room::find($request->rooms);
        $rooms->toQuery()->update(['code' => 'O']);

        //ROOM ARRAGEMENT
        if (count($request->rooms) > 0) {
            foreach ($request->rooms as $room => $v) {
                $roomArragement = [
                    'registration_id' => $registration->id,
                    'room_id' => $request->rooms[$room],
                    'totalPax' => $request->totalPax[$room],
                    'roomRate' => $request->roomRate[$room],
                    'typeOfRegistration' => $request->typeOfRegistration[$room],
                    'walkInOrReservation' => $request->walkInOrReservation[$room]
                ];
                DB::table('registration_room')->insert($roomArragement);
            }
        }

        // condition registration by reservation
        if ($request->has('idIndividualReservation')) {
            ReservationCheckInDetail::create([
                'reservation_id' => $request->idIndividualReservation,
                'registration_id' => $registration->id,
            ]);
        } elseif ($request->has('idGroupReservation')) {
            ReservationGroupCheckInDetail::create([
                'reservationgroup_id' => $request->idGroupReservation,
                'registration_id' => $registration->id
            ]);

            if ($request->has('meals')) {
                //jika ada tambahan meals/ meals req
                if (\count($request->meals)) {
                    //loop request meals
                    foreach ($request->meals as $meal => $v) {
                        $arrMealsArragement = [
                            'reservationgroup_id' => $request->idGroupReservation,
                            'meal_id' => $request->meals[$meal],
                            'atTime' => $request->timeMeal[$meal],
                        ];
                        DB::table('reservationgroup_meal')->updateOrInsert([
                            'reservationgroup_id' => $request->idGroupReservation,
                            'meal_id' => $request->meals[$meal]
                        ],$arrMealsArragement);
                    }
                }
            }
        } else {
            //return \abort(500, 'error condition registration by reservation');
        }
        \session()->flash('message', 'Registration has been added');
        return \redirect()->route('reception.registration.edit', $registration->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->registration($id);
        
        return \view('frontOffice.reception.detail', [
            'registration' => $this->registration($id),
            'grandTotal' => $this->grandTotalRoomOnly($id),
            'registrationCheckOut' => $this->dataCheckOut($id),
            'difference' => $this->difference($id),
            'guestIndividaulReservation' => $this->guestIndividaulReservation($id),
            'guestGroupReservation' => $this->guestGroupReservation($id),
            'roomSurCharges' => $this->roomSurCharges($id),
            'dataCheckIn' => CheckIn::where('registration_id', $id)->first(),
            'dataCheckOut' => CheckOut::where('registration_id', $id)->first()
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($registration)
    {   
        $guestIndividualReservation = ReservationCheckInDetail::where('registration_id', $registration)->first();

        $guestGroupReservation = ReservationGroupCheckInDetail::where('registration_id', $registration)->first();

        $registration = Registration::findOrFail($registration);
        $rooms = Room::get();
        $checkIn = new Carbon($registration->arrivaleDate);
        $checkOut = $registration->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);

        return \view('frontOffice.reception.edit', \compact(
            'registration', 'rooms', 'difference', 'guestIndividualReservation', 'guestGroupReservation'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegistrationFormRequest $request, Registration $registration)
    {
        $data = \array_merge($request->only('firstName', 'nationality', 'occupation', 'lastName', 'passport', 'dateBirth', 'homeAddress', 'company', 'arrivaleDate', 'departureDate', 'purpose', 'comingFrom', 'nextDestination', 'termOfPayment', 'numberAccount', 'clerk', 'status'));
        // \dd($data);
        $registration->update($data);

        return \redirect()->back();

        // \session()->flash('message', 'Resgistration has been changed');
        // return \redirect()->route('reception.registration.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Registration::where('id', $id)->first();
        if ($check->status == 'checkIn' || $check->status == 'checkOut') {
            $success = true;
            $message = 'Guest has checked in, data cannot be deleted';
        } else {
            $check->rooms()->update(['code' => 'VR']);
            $check->delete();
            $success = false;
            $message = 'Data has been deleted';
        }
        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function deleteRoomArragement($id)
    {
        $registrationRoom = DB::table('registration_room')->where('id', $id)->first();
        $rooms = Room::find($registrationRoom->room_id);
        $rooms->update(['code' => 'VR']);
        DB::table('registration_room')->where('id', $id)->delete();
    }

    public function editRoom(Request $request, $id)
    {
        //cek room
        $cekKamar = \collect($this->cekRoom($request))->toArray()['original'];
        if ($cekKamar['success']) {
            return \redirect()->back()->with('alert', $cekKamar['message']);
        }
        //Update room old
        $oldRoom = Room::find($request->idRoomOld);
        $oldRoom->update(['code' => 'VR']);

        DB::table('registration_room')->where('id', $id)
            ->update([
                'registration_id' => $request->idRegistration,
                'room_id' => \implode($request->rooms),
                'totalPax' => $request->totalPax,
                'roomRate' => $request->roomRate,
                'typeOfRegistration' => $request->typeOfRegistration,
                'walkInOrReservation' => $request->walkInOrReservation
            ]);
        //Update room new
        $room = Room::find(\implode($request->rooms));
        $room->update(['code' => 'O']);
        return \redirect()->back();
    }

    public function addRoom(Request $request)
    {
        $cekKamar = \collect($this->cekRoom($request))->toArray()['original'];
        if ($cekKamar['success']) {
            return \redirect()->back()->with('alert', $cekKamar['message']);
        }
        
        DB::table('registration_room')->insert([
            'registration_id' => $request->idRegistration,
            'room_id' => $request->rooms,
            'totalPax' => $request->totalPax,
            'roomRate' => $request->roomRate,
            'typeOfRegistration' => $request->typeOfRegistration,
            'walkInOrReservation' => $request->walkInOrReservation,
        ]);
        $rooms = Room::find(\implode($request->rooms));
        $rooms->update(['code' => 'O']);
        return \redirect()->back();
    }

    public function editExtraBad(Request $request, $id)
    {   
        $extraBad = Registration::find($id);
        $extraBad->extraBad->update([
            'amount' => $request->amount,
            'extrabad' => $request->extraBad,
            'rate' => $request->rate
        ]);

        return \redirect()->back();
    }

    public function deleteExtraBad($id)
    {
        $deleteExtraBad = ExtraBad::findOrFail($id);
        $deleteExtraBad->delete();
    }

    public function addExtraBed(Request $request)
    {
        $extraBedData = \array_merge($request->only('registration_id','amount', 'extraBad', 'rate'));
        ExtraBad::create($extraBedData);
        return \redirect()->back();
    }

    public function registration($id)
    {
        $registration = Registration::findOrFail($id);
        return $registration;
    }

    public function grandTotalRoomOnly($id)
    {   
        $registration = $this->registration($id);
        $checkIn = new Carbon($registration->arrivaleDate);
        $checkOut = $registration->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $grandTotalRoomOnly = $registration->rooms()->sum('roomRate') * $difference;

        return $grandTotalRoomOnly;
    }

    public function dataCheckOut($id)
    {   
        $registrationCheckOut = CheckOut::where('registration_id', $id)->first();
        return $registrationCheckOut;
    }

    public function guestIndividaulReservation($id)
    {   
        $guestIndividaulReservation = '';
        $guestIndividaulReservation = ReservationCheckInDetail::where('registration_id', $this->registration($id)->id)
        ->first();
        return $guestIndividaulReservation;
    }

    public function guestGroupReservation($id)
    {
        $guestGroupReservation = ReservationGroupCheckInDetail::where('registration_id', $this->registration($id)->id)
        ->first();      
        return $guestGroupReservation;
    }

    public function roomSurCharges($id)
    {
        $roomSurCharges = [];
        $roomSurCharges = RoomSurcharge::where([
            ['registration_id', '=', $this->registration($id)->id],
            ['typeSurCharge', '=', 'early C/I']
        ])->get();

        return $roomSurCharges;
    }

    public function difference($id)
    {   
        $registration = $this->registration($id);
        $checkIn = new Carbon($registration->arrivaleDate);
        $checkOut = $registration->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);

        return $difference;
    }

    public function cekRoom(Request $request)
    {   
        // return \response()->json($this->checkRoomStandart($request));
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
    
    public function checkRoomStandart(Request $request)
    {   
        //cek kamar
        $countRoom = Room::whereIn('id', $request->rooms)->pluck('roomType');
        
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
        //cek kamar
        $countRoom = Room::whereIn('id', $request->rooms)->pluck('roomType');

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
        //cek kamar
        $countRoom = Room::whereIn('id', $request->rooms)->pluck('roomType');

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

    public function checkDuplicateRooms(Request $request)
    {   
        $cek = (\count($request->rooms) !== \count(\array_unique($request->rooms))) ? true : \false;
        return $cek;
    }
}