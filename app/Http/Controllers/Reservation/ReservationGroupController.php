<?php

namespace App\Http\Controllers\Reservation;

use App\GroupReservationRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationGroupFormRequest;
use App\Meal;
use App\MethodPayment;
use App\ReservationGroup;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('frontOffice.reservationGroup.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::get();
        $meals = Meal::get();
        $roomRateStandart = Room::where('roomType', 'standart')->first();
        $roomRateSuperior = Room::where('roomType', 'superior')->first();
        $roomRateDeluxe = Room::where('roomType', 'deluxe')->first();
        return \view('frontOffice.reservationGroup.create', \compact('rooms', 'roomRateStandart', 'roomRateSuperior', 'roomRateDeluxe', 'meals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationGroupFormRequest $request)
    {
        // \dd($request->all());
        $rooms = Room::find($request->rooms);
        $dateReservation = Carbon::now()->isoFormat('D-M-Y');

        $checkIn = new Carbon($request->arrivaleDate);
        $checkOut = $request->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today' : $checkIn->diffInDays($checkOut);
        
        $data = \array_merge($request->only('groupName', 'arrivaleDate', 'departureDate', 'mediaReservation', 'contactPerson', 'addressPerson', 'specialRequest', 'estimateRequest', 'rateRequest', 'atTime', 'flightNumber', 'estimateArrivale','clerk' , 'status'), \compact('dateReservation'));
        $groupReservation = ReservationGroup::create($data);

        //jika ada makanan yang dipesan
        if ($request->has('meals')) {
            //jika meals arragement lebih dari 0
            if (\count($request->meals) > 0) {
                //loop request meals
                foreach ($request->meals as $meal => $v) {
                    $attach = [
                        'reservationgroup_id' => $groupReservation->id,
                        'meal_id' => $request->meals[$meal],
                        'atTime' => $request->timeMeal[$meal],
                    ];
                    DB::table('reservationgroup_meal')->insert($attach);
                }
            }
        }

        //menyimpan pengaturan room reservasi
        if (count($request->rooms) > 0) {
            foreach ($request->rooms as $room => $v) {
                //jika request room ada dan request totalRoomReserved ada, maka true
                if ($request->rooms[$room] != '' && $request->totalRoomReserved[$room] != '') {
                    $roomSelection = [
                        'reservationgroup_id' => $groupReservation->id,
                        'totalRoomReserved' => $request->totalRoomReserved[$room],
                        'totalPax' => $request->totalPax[$room],
                        'typeOfRoom' => $request->rooms[$room],
                        'roomRate' => $request->roomRate[$room],
                        'discount' => $request->discount[$room]
                    ];
                    DB::table('group_reservation_rooms')->insert($roomSelection);
                }
            }
        }

        //VALIDASI Method Payment
        $requestOther = $request->other == '' ? 'nothing' : $request->other;
        if ($request->methodPayment == 'personal') {
            MethodPayment::create([
                'reservationgroup_id' => $groupReservation->id,
                'methodPayment' => $request->methodPayment,
                'deposit' => $request->deposit,
                'value1' => $request->creditCard,
                'value2' => $request->numberAccount,
                'value3' => $requestOther,
                'status' => 0
            ]);
        } else {
            //jika methode payment company account
            MethodPayment::create([
                'reservationgroup_id' => $groupReservation->id,
                'methodPayment' => $request->methodPayment,
                'deposit' => $request->deposit,
                'value1' => $request->guarantee,
                'value2' => $request->voucher,
                'value3' => $requestOther,
                'status' => 0
            ]);
        }

        \session()->flash('message', 'Reservation has been added');
        return \redirect()->route('reservation.reservationGroup.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ReservationGroup $reservationGroup)
    {
        $checkIn = new Carbon($reservationGroup->arrivaleDate);
        $checkOut = $reservationGroup->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        return \view('frontOffice.reservationGroup.detail', \compact(
            'reservationGroup'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reservationGroup = ReservationGroup::findOrFail($id);
        $methodPayment = MethodPayment::where('reservationgroup_id', $id)->first();
        $meals = Meal::get();
        $rooms = Room::get();
        $extraBad = DB::table('group_reservation_rooms')
                ->where('typeOfRoom', '=', 'extraBad')
                ->where('reservationgroup_id', '=' ,$id)
                ->first();
        return view('frontOffice.reservationGroup.edit', \compact(
            'reservationGroup',
            'methodPayment',
            'meals', 
            'rooms',
            'extraBad'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationGroupFormRequest $request, ReservationGroup $reservationGroup)
    {
        $dateReservation = Carbon::now()->isoFormat('D-M-Y');
        $data = \array_merge($request->only('groupName', 'arrivaleDate', 'departureDate', 'mediaReservation', 'contactPerson', 'addressPerson', 'specialRequest', 'estimateRequest', 'rateRequest', 'atTime', 'estimateArrivale', 'specialRequest','clerk' , 'status'), \compact('dateReservation'));
        // \dd($request->all());
        $reservationGroup->update($data);

        //ROOM ARRAGEMENT
        if (\count($request->rooms) > \count($reservationGroup->groupReservationRooms)) {
            foreach ($request->rooms as $room => $v) {
                if ($request->rooms[$room] != '') {
                    $arrRoomArragement = [
                        'reservationgroup_id' => $reservationGroup->id,
                        'totalRoomReserved' => $request->totalRoomReserved[$room],
                        'totalPax' => $request->totalPax[$room],
                        'typeOfRoom' => $request->rooms[$room],
                        'roomRate' => $request->roomRate[$room]
                    ];
                    GroupReservationRoom::updateOrCreate([
                        'reservationgroup_id' => $reservationGroup->id,
                        'typeOfRoom' => $request->rooms[$room]
                    ],$arrRoomArragement);
                }
            }
        }

        if ($request->has('meals')) {
            //jika ada tambahan meals/ meals req > meals sekarang
            if (\count($request->meals) > \count($reservationGroup->meals)) {
                //loop request meals
                foreach ($request->meals as $meal => $v) {
                    $arrMealsArragement = [
                        'reservationgroup_id' => $reservationGroup->id,
                        'meal_id' => $request->meals[$meal],
                        'atTime' => $request->timeMeal[$meal],
                    ];
                    DB::table('reservationgroup_meal')->updateOrInsert([
                        'reservationgroup_id' => $reservationGroup->id,
                        'meal_id' => $request->meals[$meal]
                    ],$arrMealsArragement);
                }
            }
        }

        $requestOther = $request->other == '' ? 'nothing' : $request->other;
        $methodPayment = MethodPayment::where('reservationgroup_id', $reservationGroup->id)->first();
        if ($request->methodPayment == 'personal') {
            $methodPayment->update([
                'reservationgroup_id' => $reservationGroup->id,
                'methodPayment' => $request->methodPayment,
                'deposit' => $request->deposit,
                'value1' => $request->creditCard,
                'value2' => $request->numberAccount,
                'value3' => $requestOther,
                'status' => 0
            ]);
        } else {
            //jika methode payment company account
            $methodPayment->update([
                'reservationgroup_id' => $reservationGroup->id,
                'methodPayment' => $request->methodPayment,
                'deposit' => $request->deposit,
                'value1' => $request->guarantee,
                'value2' => $request->voucher,
                'value3' => $requestOther,
                'status' => 0
            ]);
        }

        \session()->flash('message', 'Reservation group been changed');
        return \redirect()->route('reservation.reservationGroup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservationGroup $reservationGroup)
    {
        if ($reservationGroup->status == 'checkIn' || $reservationGroup->status == 'checkOut') {
            $success = true;
            $message = 'Guest has chacked in, data cannot be deleted';
        } else {
            $reservationGroup->update(['status' => 0]);
            $reservationGroup->delete();

            $success = false;
            $message = 'Data has been deleted';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    public function cancelGroup()
    {
        return view('frontOffice.reservationGroup.cancelGroupView');
    }

    public function deleteMeal($id)
    {
        $deleteMeal = DB::table('reservationgroup_meal')->where('id', $id)->delete();
        return \redirect()->back();
    }

    public function detailCancelReservationGroup($id)
    {
        $reservationGroup = ReservationGroup::onlyTrashed()
            ->with('rooms', 'meals', 'methodPayment')
            ->where('id', $id)
            ->first();

        $checkIn = new Carbon($reservationGroup->arrivaleDate);
        $checkOut = $reservationGroup->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $totalMeal = $reservationGroup->meals->sum('price');
        $allTotal = $reservationGroup->totalRoomPayment + $reservationGroup->costRequest + $totalMeal;

        return \view('frontOffice.reservationGroup.detail', \compact(
            'reservationGroup',
            'difference',
            'totalMeal',
            'allTotal'
        ));
    }

    public function deleteRoomArragementGroupReservation($id)
    {
        $groupReservationRoom = GroupReservationRoom::find($id);
        $groupReservationRoom->delete();
        return \redirect()->back();
    }
}
