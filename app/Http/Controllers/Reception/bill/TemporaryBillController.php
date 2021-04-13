<?php

namespace App\Http\Controllers\Reception\bill;

use App\DetailMasterBill;
use App\Drycleanings;
use App\GuestBill;
use App\Http\Controllers\Controller;
use App\MasterBill;
use App\Orderr;
use App\Registration;
use App\ReservationCheckInDetail;
use App\ReservationGroupCheckInDetail;
use App\RoomSurcharge;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
|   Controller ini untuk pembuatan/penyimpanan sementara semua bill tamu
|--------------------------------------------------------------------------
|   semua bill meliputi
|   bill laundry, bill minibar
|   bill room, extrabed, early check in, earlt check out, melebihi batas check out,
*/

class TemporaryBillController extends Controller
{   
    public $id;

    public function registration($id)
    {
        $registration = Registration::findOrFail($id);
        return $registration;
    }

    //!
    //! saveAllBill
    //!
    public function saveAllBills(Request $request)
    {
        $id = $request->id;
        $this->registration($id);
        if ($this->guestIndividaulReservation($id)) {
            $individual = $this->allIndividualGuestBills($id);
            foreach($individual as $allGroupGuestBill){
                $allIndividualGuestBills = [
                    'registration_id' => $id,
                    'date' => $allGroupGuestBill['date'],
                    'description' => $allGroupGuestBill['description'],
                    'amount' => $allGroupGuestBill['amount'],
                    'typeBill' => $allGroupGuestBill['typeBill'],
                ];
                DB::table('temporary_bills')->insert($allIndividualGuestBills);
            }
        } elseif($this->guestGroupReservation($id)){
            $group = $this->allGroupGuestBills($id);
            foreach($group as $allGroupGuestBill){
                $allGroupGuestBills = [
                    'registration_id' => $id,
                    'date' => $allGroupGuestBill['date'],
                    'description' => $allGroupGuestBill['description'],
                    'amount' => $allGroupGuestBill['amount'],
                    'typeBill' => $allGroupGuestBill['typeBill'],
                ];
                DB::table('temporary_bills')->insert($allGroupGuestBills);
            }
        }  else {
            //jika guest walkIn
            $individual = $this->allIndividualGuestBills($id);
            foreach($individual as $allGroupGuestBill){
                $allIndividualGuestBills = [
                    'registration_id' => $id,
                    'date' => $allGroupGuestBill['date'],
                    'description' => $allGroupGuestBill['description'],
                    'amount' => $allGroupGuestBill['amount'],
                    'typeBill' => $allGroupGuestBill['typeBill'],
                ];
                DB::table('temporary_bills')->insert($allIndividualGuestBills);
            }
        }
        
        return \response()->json(['sukses' => true]);
    } 

    //!
    //! INDIVIDAUL
    //!
    public function guestIndividaulReservation($id)
    {   
        $registration = $this->registration($id);
        $guestIndividaulReservation = ReservationCheckInDetail::where('registration_id', $registration->id)
        ->first();

        return $guestIndividaulReservation;
    }

    public function allIndividualGuestBills($id)
    {   
        $registration = $this->registration($id);
        //* array GUEST BILL
        $guestBills = $this->guestBill($id);
        $dataGuestBill = [];
        foreach($guestBills as $key => $guestBill){
            $dataGuestBill[] = [
                'id' => $guestBill->id,
                'date' => $guestBill->date,
                'description' => $guestBill->description,
                'amount' => $guestBill->amount,
                'typeBill' => 'not room'
            ];
        }

        //* array ROOM CHARGE
        $dates = $this->carbonDates($id);
        foreach($registration->rooms as $room){
            foreach($dates as $key => $date){
                $dataRoomCharge[] = [
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->pivot->roomRate,
                    // 'amount' => $registration->rooms()->sum('roomRate'),
                    'typeBill' => 'rooms'
                ];
            }
        }

        //* array EXTRABED
        $dataExtraBed = [];
        if ($registration->extraBad != '') {
            foreach($dates as $key => $date){
                $dataExtraBed[] = [
                    'id' => $registration->extraBad,
                    'date' => $date,
                    'description' => 'Extra bed',
                    'amount' => $registration->extraBad['rate'],
                    'typeBill' => 'extraBed'
                ];
            }
        }

        //* jika tamu melebihi tgl check out
        $COtime = [];
        $carbonDiffCheckOutTime = $this->carbonCheckOutTime($id);
        $carbonDiffInDateCheckOut = $this->carbonDiffInDateCheckOut($id);
        foreach($registration->rooms as $room){
            foreach($carbonDiffInDateCheckOut as $date){
                $COtime[] = [
                    'id' => $room->id,
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->pivot->roomRate,
                    // 'amount' => $room->price,
                    // 'amount' => $registration->rooms()->sum('roomRate')
                    'typeBill' => 'diffDateInCO'
                ];
            }
        }

        //*Room Surcharge early Check In
        $roomSurchargesEarlyCheckIn = [];
        foreach($this->roomSurchargesEarlyCheckIn($id) as $roomSurcharge){
            $roomSurchargesEarlyCheckIn[] = [
                'id' => $roomSurcharge->id,
                'date' => $roomSurcharge->registration->checkIn->date->format('Y-m-d'),
                'description' => 'Room surcharge early check in '.$roomSurcharge->typeRoom,
                'amount' => $roomSurcharge->roomSurCharge,
                'typeBill' => 'roomSurcharge',
            ];
        }

        //*Room surcharge early check Out
        $roomSurchargesEarlyCheckOut = [];
        $jamSekarang = Carbon::now()->toTimeString();
        $jamDuaBelasSiang = Carbon::now()->format('12:00');
        if ($jamSekarang > $jamDuaBelasSiang) {
            $dates = $this->carbonDates($id);
            foreach($registration->rooms as $room){
                foreach($dates as $key => $date){
                    $roomSurchargesEarlyCheckOut[] = [
                        'date' => $date,
                        'description' => 'Room surcharge early check out '.$room->roomType,
                        'amount' => $room->pivot->roomRate/2,
                        'typeBill' => 'roomSurcharge'
                    ];
                }
            }
        }

        //* array MINIBAR/ORDERR
        $miniBarBills = [];
        foreach($this->getMiniBarBills($id) as $miniBarBill){
            foreach($miniBarBill->orderrdetails as $detail){
                $miniBarBills[] = [
                    'id' => $detail->id,
                    'date' => $miniBarBill->date,
                    'description' => "Minibar order $detail->quantity x " .$detail->product->name,
                    'amount' => $detail->quantity * $detail->product->price,
                    'typeBill' => 'minibar'
                ];
            }
        }
        
        //* array LAUNDRY
        $laundryBiils = [];
        foreach($this->getLaundryBills($id) as $laundry){
            foreach($laundry->drycleaning_details as $detail){
                $laundryBiils[] = [
                    'id' => $detail->id,
                    'date' => $laundry->date,
                    'description' => "Laundry $detail->quantity x " .$detail->package->name,
                    'amount' => $detail->quantity * $detail->package->price,
                    'typeBill' => 'laundry'
                ];
            }
        }

        //!BATAS
        $merged = \array_merge($dataGuestBill, $dataRoomCharge, $dataExtraBed, $COtime, $roomSurchargesEarlyCheckIn, $roomSurchargesEarlyCheckOut, $miniBarBills, $laundryBiils);
        $collect = collect($merged)->sortBy('date');

        $allGuestBillIndividual = [];
        $id = 1;
        foreach($collect as $allGuestBill){
            $allGuestBillIndividual[] = [
                'id' => $id++,
                'date' => $allGuestBill['date'],
                'description' => $allGuestBill['description'],
                'amount' => $allGuestBill['amount'],
                'typeBill' => $allGuestBill['typeBill'],
            ];
        }

        return $allGuestBillIndividual;
    }

    //!
    //! GROUP
    //!

    public function guestGroupReservation($id)
    {
        $guestGroupReservation = ReservationGroupCheckInDetail::where('registration_id', $this->registration($id)->id)
        ->first();
        
        return $guestGroupReservation;
    }

    public function allGroupGuestBills($id)
    {
        $registration = $this->registration($id);
        //array guestbill
        $guestBills = $this->guestBill($id);
        $dataGuestBill = [];
        foreach($guestBills as $key => $guestBill){
            $dataGuestBill[] = [
                'date' => $guestBill->date,
                'description' => $guestBill->description,
                'amount' => $guestBill->amount,
                'typeBill' => 'otherCash'
            ];
        }

        //array ROOM CHARGE
        $dates = $this->carbonDates($id);
        foreach($registration->rooms as $room){
            foreach($dates as $key => $date){
                $dataRoomCharge[] = [
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->pivot->roomRate,
                    // 'amount' => $registration->rooms()->sum('roomRate'),
                    'typeBill' => 'rooms'
                ];
            }
        }

        //Meals arragement
        $guestGroupReservation = $this->guestGroupReservation($id);
        $dataMeals = [];
        if ($guestGroupReservation) {
            foreach($guestGroupReservation->reservationGroup->Meals as $key => $meal){
                foreach($dates as $ket => $date){
                    $dataMeals[] = [
                        'date' => $date,
                        'description' => 'Meal '.$meal->type,
                        'amount' => '0',
                        // 'amount' => $registration->rooms()->sum('roomRate')
                        'typeBill' => 'meals'
                    ];
                }
            }
        }

        //array extraBed
        $dataExtraBed = [];
        if ($registration->extraBad != '') {
            foreach($dates as $key => $date){
                $dataExtraBed[] = [
                    'date' => $date,
                    'description' => 'Extra bed',
                    'amount' => $registration->extraBad['rate'],
                    'typeBill' => 'extraBed'
                ];
            }
        }

        // jika tamu melebihi tgl check out
        $COtime = [];
        $carbonDiffCheckOutTime = $this->carbonCheckOutTime($id);
        $carbonDiffInDateCheckOut = $this->carbonDiffInDateCheckOut($id);
        foreach($registration->rooms as $room){
            foreach($carbonDiffInDateCheckOut as $date){
                $COtime[] = [
                    'id' => $room->id,
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->price,
                    // 'amount' => $registration->rooms()->sum('roomRate')
                    'typeBill' => 'diffDateInCO'
                ];
            }
        }

        //Room Surcharge early Check In
        $roomSurchargesEarlyCheckIn = [];
        foreach($this->roomSurchargesEarlyCheckIn($id) as $roomSurcharge){
            $roomSurchargesEarlyCheckIn[] = [
                'id' => $roomSurcharge->id,
                'date' => $roomSurcharge->registration->checkIn->date->format('Y-m-d'),
                'description' => 'Room surcharge early check in '.$roomSurcharge->typeRoom,
                'amount' => $roomSurcharge->roomSurCharge,
                'typeBill' => 'roomSurcharge',
            ];
        }

        //Room surcharge early check Out
        $roomSurchargesEarlyCheckOut = [];
        $jamSekarang = Carbon::now()->toTimeString();
        $jamDuaBelasSiang = Carbon::now()->format('12:00');
        if ($jamSekarang > $jamDuaBelasSiang) {
            $dates = $this->carbonDates($id);
            foreach($registration->rooms as $room){
                foreach($dates as $key => $date){
                    $roomSurchargesEarlyCheckOut[] = [
                        'date' => $date,
                        'description' => 'Room surcharge early check out '.$room->roomType,
                        'amount' => $room->pivot->roomRate/2,
                        'typeBill' => 'roomSurcharge'
                    ];
                }
            }
        }

        //* array MINIBAR/ORDERR
        $miniBarBills = [];
        foreach($this->getMiniBarBills($id) as $miniBarBill){
            foreach($miniBarBill->orderrdetails as $detail){
                $miniBarBills[] = [
                    'id' => $detail->id,
                    'date' => $miniBarBill->date,
                    'description' => "Minibar order $detail->quantity x " .$detail->product->name,
                    'amount' => $detail->quantity * $detail->product->price,
                    'typeBill' => 'minibar'
                ];
            }
        }

        //* array LAUNDRY
        $laundryBiils = [];
        foreach($this->getLaundryBills($id) as $laundry){
            foreach($laundry->drycleaning_details as $detail){
                $laundryBiils[] = [
                    'id' => $detail->id,
                    'date' => $laundry->date,
                    'description' => "Laundry $detail->quantity x " .$detail->package->name,
                    'amount' => $detail->quantity * $detail->package->price,
                    'typeBill' => 'laundry'
                ];
            }
        }

        //!BATAS
        $merged = \array_merge($dataGuestBill, $dataRoomCharge, $dataExtraBed, $COtime, $roomSurchargesEarlyCheckIn, $roomSurchargesEarlyCheckOut, $miniBarBills, $laundryBiils);
        $collect = collect($merged)->sortBy('date');

        $allGroupGuestBills = [];
        $id = 1;
        foreach($collect as $allGroupGuestBill){
            $allGroupGuestBills[] = [
                'id' => $id++,
                'date' => $allGroupGuestBill['date'],
                'description' => $allGroupGuestBill['description'],
                'amount' => $allGroupGuestBill['amount'],
                'typeBill' => $allGroupGuestBill['typeBill'],
            ];
        }

        return $allGroupGuestBills;
    }

    //!
    //! OTHER FUNCTION
    //!
    public function totalRoomCash($id)
    {   
        $registration = $this->registration($id);
        $checkIn = new Carbon($registration->arrivaleDate);
        $checkOut = $registration->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $totalRoomCash = ($registration->rooms()->sum('roomRate') * $difference) + ($registration->extraBad['rate'] * $difference);

        return $totalRoomCash;
    }

    public function getMiniBarBills($id)
    {
        $registration = $this->registration($id);
        $minibar = [];
        foreach($registration->rooms as $room){
            $rooms[] = $room->id;
            $minibar = Orderr::whereBetween('date', [
                $registration->arrivaleDate, $registration->departureDate
            ])->whereIn('room_id', $rooms)->get();
        }

        return $minibar;
    }

    public function getLaundryBills($id)
    {
        $registration = $this->registration($id);
        $laundry = [];
        foreach($registration->rooms as $room){
            $rooms[] = $room->id;
            $laundry = Drycleanings::whereBetween('date', [
                $registration->arrivaleDate, $registration->departureDate
            ])->whereIn('room_id', $rooms)->get();
        }

        return $laundry;
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

    public function guestBill($id)
    {
        $registration = $this->registration($id);
        $guestBills = [];
        foreach($registration->rooms as $room){
            $rooms[] = $room->id;
            $guestBills = GuestBill::whereBetween('date', [
                $registration->arrivaleDate, $registration->departureDate
            ])->whereIn('room_id', $rooms)->get();
        }

        return $guestBills;
    }

    public function carbonDates($id)
    {
        $registration = $this->registration($id);
        $start = Carbon::parse($registration->arrivaleDate)->addDay(); //11-03-2021 maju 1 tanggal
        $end = Carbon::parse($registration->departureDate); //14-03-2021 ->subDay(); mundur 1 tanggal
        $dateRange = CarbonPeriod::create($start, $end);
        $dates = [];
        foreach($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    public function carbonCheckOutTime($id) //jika tamu melebihi tgl C/O
    {
        $registration = $this->registration($id);
        $toDay = new Carbon(); //toDay
        $checkOut = $registration->departureDate;
        $difference = ($toDay->diff($checkOut)->days < -1)
            ? 'today'
            : $toDay->diffInDays($checkOut);
        return $difference;
    }

    public function carbonDiffInDateCheckOut($id) //selisi dari tgl C/O - sekarang
    {
        $registration = $this->registration($id);
        $checkOut = Carbon::parse($registration->departureDate)->addDay();
        $toDay = Carbon::now()->format('Y-m-d');
        $dateRange = CarbonPeriod::create($checkOut, $toDay);
        $dates = [];
        foreach($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        
        return $dates;
    }

    public function resetAllBill($id)
    {   
        $deleteMasterBill = MasterBill::where('registration_id', $id)->get();
        $deleteMasterBill->each->delete();
        $deleteTemporaryBills = DB::table('temporary_bills')->where([
            ['registration_id', $id],
            ['typeBill', '!=', 'not room']
        ])->delete();

        return \response()->json(['sukses' => true]);
    }

    public function roomSurchargesEarlyCheckIn($id)
    {
        $roomSurCharges = [];
        $roomSurCharges = RoomSurcharge::where([
            ['registration_id', '=', $this->registration($id)->id],
            ['typeSurCharge', '=', 'early C/I']
        ])->get();

        return $roomSurCharges;
    }
}
