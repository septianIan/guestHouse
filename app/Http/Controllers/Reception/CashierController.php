<?php

namespace App\Http\Controllers\Reception;

use App\Drycleanings;
use App\Http\Controllers\Controller;
use App\MiscellaneousVoucher;
use App\Orderr;
use App\PaidOutVoucher;
use App\Registration;
use App\ReservationCheckInDetail;
use App\ReservationGroupCheckInDetail;
use App\TelephoneVoucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashierController extends Controller
{
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
        $registration = Registration::findOrFail($id);

        $guestIndividaulReservation = ReservationCheckInDetail::where('registration_id', $id)
        ->first();

        $guestGroupReservation = ReservationGroupCheckInDetail::where('registration_id', $id)
        ->first();

        $checkIn = new Carbon($registration->arrivaleDate);
        $checkOut = $registration->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $totalRoomCash = ($registration->rooms()->sum('roomRate') * $difference) + ($registration->extraBad['rate'] * $difference);

        /**
         * BILL
         */
        //Telphone
        $billTelephone = TelephoneVoucher::where('registration_id', $id)->latest()->get();
        $totalTelephone = 0;
        foreach($billTelephone as $v){
            $totalTelephone += $v->amount;
        }

        //Miscellaneous
        $billMiscellaneous = MiscellaneousVoucher::where('registration_id', $id)->latest()->get();
        $totalMiscellaneous = 0;
        foreach ($billMiscellaneous as $v) {
            $totalMiscellaneous += $v->amount;
        }

        //Paid out
        $billPaidOut = PaidOutVoucher::latest()->get();

        // Minibar cash
        foreach($registration->rooms as $regis){
            $guestRegis[] = $regis->id;
            $billMinibar = Orderr::whereBetween('date', [
                $registration->arrivaleDate, $registration->departureDate
            ])->whereIn('room_id', $guestRegis)->get(); 
        }

        $totalCashMinibar = 0;
        foreach($billMinibar as $order){
            foreach($order->orderrdetails as $orderDetail){
                $totalCashMinibar += $orderDetail->amount;
            }
        }

        // LAUNDRY
        foreach($registration->rooms as $regis){
            $guestRegisDryCleaning[] = $regis->id;
            $billLaundry = Drycleanings::whereBetween('date', [
                $registration->arrivaleDate, $registration->departureDate
            ])->whereIn('room_id', $guestRegisDryCleaning)->get(); 
        }

        $totalDrycleaning = 0;
        foreach($billLaundry as $drycleaning){
            foreach($drycleaning->drycleaning_details as $drycleaningDetail){
                $totalDrycleaning += $drycleaningDetail->amount;
            }
        }

        /**
         * TOTAL ALL CASH
         */
        $totalAllCashGuest = $totalRoomCash + $totalTelephone + $totalMiscellaneous + $totalCashMinibar;
        return \view('frontOffice.reception.cashier.detail', [
            'registration' => $registration,
            'difference' => $difference,
            'totalRoomCash' => $totalRoomCash,
            'guestIndividaulReservation' => $guestIndividaulReservation,
            'guestGroupReservation' => $guestGroupReservation,

            'billTelephone' => $billTelephone,
            'totalTelephone' => $totalTelephone,

            'billMiscellaneous' => $billMiscellaneous,
            'totalMiscellaneous' => $totalMiscellaneous,

            'billPaidOut' => $billPaidOut,
            
            'billMinibar' => $billMinibar,
            'totalCashMinibar' => $totalCashMinibar,

            'billLaundry' => $billLaundry,
            'totalDrycleaning' => $totalDrycleaning,

            'totalAllCashGuest' => $totalAllCashGuest,
        ]);
    }
}
