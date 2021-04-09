<?php

namespace App\Http\Controllers\Reception;

use App\DetailMasterBill;
use App\GuestBill;
use App\Http\Controllers\Controller;
use App\MasterBill;
use App\Registration;
use App\ReservationCheckInDetail;
use App\ReservationGroupCheckInDetail;
use App\RoomSurcharge;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public $id;

    public function index()
    {
        return view('frontOffice.reception.cashier.index');
    }

    public function dtGuestCheckIn()
    {
        $registration = Registration::where('status', 'checkIn')->latest()->get();
        return \datatables()->of($registration)
            ->addColumn('action', function($registration){
                $btn = '<a href="/reception/guest/checkIn/detail/' . $registration->id . '" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->addColumn('status', function($registration){
                if ($registration->status == 'checkIn') {
                    $data = '<font style="color:blue;font-weight:bold;">'.'Check In'.'</font>';
                } else {
                    $data = '<font style="color:red;font-weight:bold;">'.'Not checked in yet'.'</font>';
                }
                return $data;
            })
            ->addColumn('guestName', function($registration){
                return $registration->getGuestName();
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->toJson();
    }

    public function detailGuetsCheckIn($id)
    {
        $this->registration($id);
        $temporaryBills = DB::table('temporary_bills')->where('registration_id', $id)->orderBy('date', 'ASC')->get();

        //all guest bill individual
        $allIndividualGuestBills = $this->allIndividualGuestBills($id);
        foreach($allIndividualGuestBills as $v){
            $billIndividual[] = $v['amount'];
        }

        // All guest bill group
        $allGroupGuestBills = $this->allGroupGuestBills($id);
        foreach($allGroupGuestBills as $v){
            $billGroup[] = $v['amount'];
        }

        $amountRefund = '';
        $totalCash = '';
        $allBill = '';
        if ($this->guestIndividaulReservation($id)) {
            $amountRefund = $this->guestIndividaulReservation($id)->reservation->deposit - \array_sum($billIndividual);

            $totalCash = $this->guestIndividaulReservation($id)->reservation->deposit >= \array_sum($billIndividual) ? 'REFUND' : 'REPAYMENT';

            $allBill = \array_sum($billIndividual);

        } elseif($this->guestGroupReservation($id)){

            $amountRefund = $this->guestGroupReservation($id)->reservationGroup->methodPayment->deposit - \array_sum($billGroup);

            $totalCash = $this->guestGroupReservation($id)->reservationGroup->methodPayment->deposit - \array_sum($billGroup) > \array_sum($billGroup) ? 'REFUND' : 'REPAYMENT';

            $allBill = \array_sum($billGroup);
        } else {
            //jika tamu walkIn
            $allBill = \array_sum($billIndividual);
        }
        
        return \view('frontOffice.reception.cashier.detail', [
            'registration' => $this->registration($id),
            'difference' => $this->difference($id),
            'totalRoomCash' => $this->totalRoomCash($id),
            'guestIndividaulReservation' => $this->guestIndividaulReservation($id),
            'guestGroupReservation' => $this->guestGroupReservation($id),
            'allIndividualGuestBills' => $temporaryBills,
            'allGroupGuestBills' => $temporaryBills,
            'refund' => $amountRefund,
            'totalCash' => $totalCash,
            'allBill' => $allBill,
        ]);
    }

    public function registration($id)
    {
        $registration = Registration::findOrFail($id);
        return $registration;
    }

    public function guestIndividaulReservation($id)
    {   
        $registration = $this->registration($id);
        $guestIndividaulReservation = ReservationCheckInDetail::where('registration_id', $registration->id)
        ->first();

        return $guestIndividaulReservation;
    }

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

    public function allIndividualGuestBills($id)
    {   
        $registration = $this->registration($id);
        //array guestbill
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

        //array ROOM CHARGE
        $dates = $this->carbonDates($id);
        $dataRoomCharge = [];
        foreach($registration->rooms as $room){
            foreach($dates as $key => $date){
                $dataRoomCharge[] = [
                    'id' => $room->id,
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->price,
                    // 'amount' => $registration->rooms()->sum('roomRate')
                    'typeBill' => 'rooms'
                ];
            }
        }

        //array extraBed
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

        // jika tamu melebihi tgl check out
        $COtime = [];
        $carbonDiffInDateCheckOut = $this->carbonDiffInDateCheckOut($id);
        foreach($registration->rooms as $room){
            foreach($carbonDiffInDateCheckOut as $date){
                $COtime[] = [
                    'id' => $room->id,
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->price,
                    // 'amount' => $registration->rooms()->sum('roomRate')
                    'typeBill' => 'Tamu melebihi C/O'
                ];
            }
        }

        //Room Surcharge early Check In
        $roomSurchargesEarlyCheckIn = [];
        foreach($this->roomSurchargesEarlyCheckIn($id) as $roomSurcharge){
            $roomSurchargesEarlyCheckIn[] = [
                'id' => $roomSurcharge->id,
                'date' => $roomSurcharge->registration->checkIn->date->format('Y-m-d'),
                'description' => 'Room surcharge early check in '.$room->roomType,
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

        //!BATAS
        $merged = \array_merge($dataGuestBill, $dataRoomCharge, $dataExtraBed, $COtime, $roomSurchargesEarlyCheckIn, $roomSurchargesEarlyCheckOut);
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

    public function masterBill($id)
    {   

    }

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
        $dataRoomCharge = [];
        foreach($registration->rooms as $room){
            foreach($dates as $key => $date){
                $dataRoomCharge[] = [
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->price,
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
        $carbonDiffInDateCheckOut = $this->carbonDiffInDateCheckOut($id);
        foreach($registration->rooms as $room){
            foreach($carbonDiffInDateCheckOut as $date){
                $COtime[] = [
                    'id' => $room->id,
                    'date' => $date,
                    'description' => 'Room charge '.$room->roomType,
                    'amount' => $room->price,
                    // 'amount' => $registration->rooms()->sum('roomRate')
                    'typeBill' => 'Tamu melebihi C/O'
                ];
            }
        }
        
        
        //Room Surcharge early Check In
        $roomSurchargesEarlyCheckIn = [];
        foreach($this->roomSurchargesEarlyCheckIn($id) as $roomSurcharge){
            $roomSurchargesEarlyCheckIn[] = [
                'id' => $roomSurcharge->id,
                'date' => $roomSurcharge->registration->checkIn->date->format('Y-m-d'),
                'description' => 'Room surcharge early check in '.$room->roomType,
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

        //!BATAS
        $merged = \array_merge($dataGuestBill, $dataRoomCharge, $dataMeals, $dataExtraBed, $COtime, $roomSurchargesEarlyCheckIn, $roomSurchargesEarlyCheckOut);
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
