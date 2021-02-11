<?php

namespace App\Http\Controllers\Reception;

use App\ExtraBad;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationFormRequest;
use App\Registration;
use App\Reservation;
use App\ReservationCheckInDetail;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data = \array_merge($request->except('_token', 'roomNo', 'totalPax', 'roomRate', 'typeOfRegistration', 'walkInOrReservation', 'rooms', 'idReservation', 'amount', 'extraBad', 'rate', 'idRooms'));
        $registration = Registration::create($data);

        $registration_id = $registration->id;
        if ($request->has('extraBad')) {
            $extraBadData = \array_merge($request->only('amount', 'extraBad', 'rate'), \compact('registration_id'));
            ExtraBad::create($extraBadData);
        }
        
        $rooms = Room::find($request->rooms);
        $rooms->toQuery()->update(['code' => 'O']);

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
        if ($request->has('idReservation')) {
            ReservationCheckInDetail::create([
                'reservation_id' => $request->idReservation,
                'registration_id' => $registration->id,
            ]);
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
        $registration = Registration::findOrFail($id);
        $guestReservation = ReservationCheckInDetail::where('registration_id', $id)->first();
        $checkIn = new Carbon($registration->arrivaleDate);
        $checkOut = $registration->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $grandTotal = $registration->rooms()->sum('roomRate') * $difference;

        return \view('frontOffice.reception.detail', \compact(
            'registration',
            'difference',
            'grandTotal',
            'guestReservation'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($registration)
    {   
        $guestReservation = ReservationCheckInDetail::where('registration_id', $registration)->first();
        $registration = Registration::findOrFail($registration);
        $rooms = Room::get();
        $checkIn = new Carbon($registration->arrivaleDate);
        $checkOut = $registration->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);

        return \view('frontOffice.reception.edit', \compact(
            'registration', 'rooms', 'difference', 'guestReservation'
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
        $data = \array_merge($request->only('firstName', 'nationality', 'occupation', 'lastName', 'passport', 'dateBirth', 'homeAddress', 'company', 'arrivaleDate', 'departureDate', 'purpose', 'comingFrom', 'nextDestination', 'termOfPayment', 'numberAccount', 'status'));
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
        if ($check->status == 'checkIn') {
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
        //Update room old
        $oldRoom = Room::find($request->idRoomOld);
        $oldRoom->update(['code' => 'VR']);
        DB::table('registration_room')->where('id', $id)
            ->update([
                'registration_id' => $request->idRegistration,
                'room_id' => $request->rooms,
                'totalPax' => $request->totalPax,
                'roomRate' => $request->roomRate,
                'typeOfRegistration' => $request->typeOfRegistration,
                'walkInOrReservation' => $request->walkInOrReservation
            ]);
        //Update room new
        $room = Room::find($request->rooms);
        $room->update(['code' => 'O']);
        return \redirect()->back();
    }

    public function addRoom(Request $request)
    {
        DB::table('registration_room')->insert([
            'registration_id' => $request->idRegistration,
            'room_id' => $request->rooms,
            'totalPax' => $request->totalPax,
            'roomRate' => $request->roomRate,
            'typeOfRegistration' => $request->typeOfRegistration,
            'walkInOrReservation' => $request->walkInOrReservation,
        ]);
        $rooms = Room::find($request->rooms);
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

    public function addExtraBad(Request $request)
    {
        $extraBadData = \array_merge($request->only('registration_id','amount', 'extraBad', 'rate'));
        ExtraBad::create($extraBadData);
        return \redirect()->back();
    }
}
