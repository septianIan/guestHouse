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
        return \view('frontOffice.reservationGroup.create', \compact('rooms', 'meals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationGroupFormRequest $request)
    {
        $rooms = Room::find($request->rooms);
        $dateReservation = Carbon::now()->isoFormat('D-M-Y');

        $checkIn = new Carbon($request->arrivaleDate);
        $checkOut = $request->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today' : $checkIn->diffInDays($checkOut);
        
        $data = \array_merge($request->only('groupName', 'arrivaleDate', 'departureDate', 'mediaReservation', 'namePerson', 'contactPerson', 'addressPerson', 'specialRequest', 'estimateRequest', 'rateRequest', 'atTime', 'flightNumber', 'estimateArrivale', 'status'), \compact('dateReservation', 'specialRequest'));
        $groupReservation = ReservationGroup::create($data);

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

        if (count($request->rooms) > 0) {
            foreach ($request->rooms as $room => $v) {
                $roomSelection = [
                    'reservationgroup_id' => $groupReservation->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$room],
                    'typeOfRoom' => $request->rooms[$room],
                    'roomRate' => $request->roomRate[$room]
                ];
                DB::table('group_reservation_rooms')->insert($roomSelection);
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
        
        $groupReservationRoom = DB::table('group_reservation_rooms')
                                ->where('reservationgroup_id', $reservationGroup->id)
                                ->get();

        $total = 0;
        foreach($groupReservationRoom as $value){
            $total += $value->roomRate * $value->totalRoomReserved * $difference;
        }

        return \view('frontOffice.reservationGroup.detail', \compact(
            'reservationGroup',
            'difference',
            'total'
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
        $data = \array_merge($request->only('groupName', 'arrivaleDate', 'departureDate', 'mediaReservation', 'namePerson', 'contactPerson', 'addressPerson', 'specialRequest', 'estimateRequest', 'rateRequest', 'atTime', 'estimateArrivale', 'specialRequest', 'status'), \compact('dateReservation'));
        // \dd($request->all());
        $reservationGroup->update($data);

        //ROOMS ARRAGEMENT
        for ($i = 0; $i < \count($request->idRooms); $i++) {
            DB::table('group_reservation_rooms')->where('id', $request->idRooms[$i])
                ->update([
                    'reservationgroup_id' => $reservationGroup->id,
                    'totalRoomReserved' => $request->totalRoomReserved[$i],
                    'typeOfRoom' => $request->rooms[$i],
                    'roomRate' => $request->roomRate[$i]
                ]);
        }
        //jika ada tambahan room
        if (\count($request->rooms) > \count($reservationGroup->groupReservationRooms)) {
            if (count($request->rooms) > 0) {
                foreach ($request->rooms as $room => $v) {
                    $arrRoomArragement = [
                        'reservationgroup_id' => $reservationGroup->id,
                        'totalRoomReserved' => $request->totalRoomReserved[$room],
                        'typeOfRoom' => $request->rooms[$room],
                        'roomRate' => $request->roomRate[$room]
                    ];
                    GroupReservationRoom::updateOrCreate($arrRoomArragement, [
                        'reservationgroup_id' => $reservationGroup->id
                    ]);
                }
            }
        }

        //MEALS ARRAGEMENT
        for ($i = 0; $i < \count($request->idMeals); $i++) {
            DB::table('reservationgroup_meal')->where('id', $request->idMeals[$i])
                ->update([
                    'reservationgroup_id' => $reservationGroup->id,
                    'meal_id' => $request->meals[$i],
                    'atTime' => $request->timeMeal[$i],
                ]);
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
                    DB::table('reservationgroup_meal')->updateOrInsert($arrMealsArragement, ['reservationgroup_id' => $reservationGroup->id]);
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
        // $reservationGroup->rooms()->update(['code' => 'VR']);
        $reservationGroup->update(['status' => 0]);
        $reservationGroup->delete();
        return \response()->json(['sukses' => true]);
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
