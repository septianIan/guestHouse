<?php

namespace App\Http\Controllers\Reservation;


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
                    ? 'today' :$checkIn->diffInDays($checkOut);
                    //selisih dari arrivale dan departure di kalikan jumlah sum rooms
        $totalRoomPayment = $difference*=$rooms->sum('price');

        //jika metode pembayarannya personal maka ouput yang di hasilkan value dari creditCard jika tidak value dari voucher
        $noMethodPayment = $request->methodPayment == 'personal' ? $request->creditCard : $request->voucher;
        
        $arrayReq = [
            $request->specialRequest, $request->atTime
        ];
        $specialRequest = \implode(" ", $arrayReq);


        $data = \array_merge($request->only('groupName', 'arrivaleDate', 'departureDate', 'namePerson', 'contactPerson', 'addressPerson', 'specialRequest', 'estimateRequest', 'costRequest', 'estimateArrivale'), \compact('totalRoomPayment','dateReservation', 'specialRequest'));

        $rooms->toQuery()->update(['status' => 'O']);
        $groupReservation = ReservationGroup::create($data);
        $groupReservation->rooms()->attach($rooms);

        //jika meals arragement lebih dari 0
        if (\count($request->meals) > 0) {
            //loop request meals
            foreach($request->meals as $meal=>$v) {
                $attach = [
                    'reservationgroup_id' => $groupReservation->id,
                    'meal_id' => $request->meals[$meal],
                    'atTime' => $request->timeMeal[$meal],
                ];
                DB::table('reservationgroup_meal')->insert($attach);
            }
        }

        $requestOther = $request->other == '' ? 'nothing' : $request->other;
        if ($request->methodPayment == 'personal') {
            MethodPayment::create([
                'reservationgroup_id' => $groupReservation->id,
                'methodPayment' => $request->methodPayment,
                'value2' => $request->deposit,
                'value3' => $request->creditCard,
                'value4' => $requestOther,
                'status' => 0
            ]);
        } else {
            //jika methode payment company account
            MethodPayment::create([
                'reservationgroup_id' => $groupReservation->id,
                'methodPayment' => $request->methodPayment,
                'value2' => $request->guarantee,
                'value3' => $request->voucher,
                'value4' => $requestOther,
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
        $totalMeal = $reservationGroup->meals->sum('price');
        $allTotal = $reservationGroup->totalRoomPayment + $reservationGroup->costRequest + $totalMeal;

        return \view('frontOffice.reservationGroup.detail', \compact(
            'reservationGroup', 
            'difference',
            'totalMeal',
            'allTotal'
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
        $reservationGroup = ReservationGroup::find($id);
        $methodPayment = MethodPayment::where('reservationgroup_id', $id)->first();
        $meals = Meal::get();
        $rooms = Room::get();
        return view('frontOffice.reservationGroup.edit', \compact('reservationGroup', 'methodPayment', 'meals', 'rooms'));
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
        $data = $request->except('_token','deposit','creditCard','otherPersonal','guarantee','methodPayment', 'voucher');        
        $reservationGroup->update($data);

        $requestOther = $request->other == '' ? 'nothing' : $request->other;
        $methodPayment = MethodPayment::where('reservationgroup_id' ,$reservationGroup->id)->first();
        
        if ($request->methodPayment == 'personal') {
            $methodPayment->update([
                'reservationgroup_id' => $reservationGroup->id,
                'methodPayment' => $request->methodPayment,
                'value2' => $request->deposit,
                'value3' => $request->creditCard,
                'value4' => $requestOther,
                'status' => 0
            ]);
        } else {
            //jika methode payment company account
            $methodPayment->update([
                'reservationgroup_id' => $reservationGroup->id,
                'methodPayment' => $request->methodPayment,
                'value2' => $request->guarantee,
                'value3' => $request->voucher,
                'value4' => $requestOther,
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
        $reservationGroup->rooms()->update(['status' => 'VR']);
        $reservationGroup->delete();
        return \response()->json(['sukses' => true]);
    }

    public function deleteMeal(Request $request ,$id)
    {
        $meals = Meal::find($request->idMeal);
        $reservationGroup = ReservationGroup::find($id);

        $meals->reservationGroups()->detach($reservationGroup);
        return \redirect()->back();
    }

    public function addMeal(Request $request)
    {
        $meals = Meal::find($request->meals);
        $reservationGroup = ReservationGroup::find($request->id);
        $reservationGroup->meals()->attach($meals, ['atTime' => $request->timeMeal]);
        return \redirect()->back();
    }

    public function deleteRoom(Request $request, $id)
    {
        $rooms = Room::find($request->idRoom);
        $reservationGroup = ReservationGroup::find($id);

        $checkIn = new Carbon($reservationGroup->arrivaleDate);
        $checkOut = $reservationGroup->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1) 
                    ? 'today' :$checkIn->diffInDays($checkOut);
        $totalRoomPayment = $reservationGroup->totalRoomPayment - ($rooms->price * $difference);
        $rooms->update(['status' => 'VR']);
        $reservationGroup->update(['totalRoomPayment' => $totalRoomPayment]);
        $rooms->reservationGroups()->detach($reservationGroup);

        return \redirect()->back();
        
    }

    public function addRoom(Request $request)
    {
        $rooms = Room::find($request->rooms);
        $reservationGroup = ReservationGroup::find($request->id);

        $checkIn = new Carbon($reservationGroup->arrivaleDate);
        $checkOut = $reservationGroup->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1) 
                    ? 'today' :$checkIn->diffInDays($checkOut);
        $totalRoomPayment = ($difference * $rooms->sum('price') + $reservationGroup->totalRoomPayment);
        
        $rooms->toQuery()->update(['status' => 'O']);
        $reservationGroup->update(['totalRoomPayment'=> $totalRoomPayment]);
        $reservationGroup->rooms()->attach($rooms);
        return \redirect()->back();

    }
}
