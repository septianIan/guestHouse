<?php

namespace App\Http\Controllers\Reception\bill;

use App\CheckOut;
use App\Http\Controllers\Controller;
use App\Registration;
use App\Reservation;
use App\ReservationCheckInDetail;
use App\ReservationGroupCheckInDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{   
    public $id;
    public function getId($id)
    {
        return $id;
    }

    public function checkOut($id)
    {
        $this->getId($id);
        //!jika masih ada data yang statusnya 0
        if ($this->getCheckStatusTemporaryBills($id)->isNotEmpty()) {
            $success = true;
            $message = 'Make sure the master has been created or all the master bills have been paid';
        } else {
            CheckOut::create([
                'registration_id' => $id,
                'date' => Carbon::now()->format('Y-m-d'),
                'time' => Carbon::now()->format('H:i:s')
            ]);
            $this->updateStatusCheckOut($id);
            $success = false;
            $message = 'oke';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    public function getCheckStatusTemporaryBills($id)
    {
        $checkStatusTemporaryBills = DB::table('temporary_bills')->where([
            ['registration_id', '=', $this->getId($id)],
            ['status', '=', 0],
        ])->get();

        return $checkStatusTemporaryBills;
    }

    public function updateStatusCheckOut($id)
    {
        $regisDetail = ReservationCheckInDetail::where('registration_id', $this->getId($id))->first();
        $groupReservation = ReservationGroupCheckInDetail::where('registration_id', $this->getId($id))->first();
        if ($regisDetail != '') {
            $regisDetail->reservation->update(['status' => 'checkOut']);
            $regisDetail->registration->update(['status' => 'checkOut']);
            DB::table('individual_reservation_rooms')->whereIn('reservation_id', [$regisDetail->reservation_id])
                ->update(['status' => 0]);
        } 
        if($groupReservation != '') {
            $groupReservation->reservationGroup->update(['status' => 'checkOut']);
            $groupReservation->registration->update(['status' => 'checkOut']);
            DB::table('group_reservation_rooms')->whereIn(
                'reservationgroup_id', [$groupReservation->reservationgroup_id]
            )->update(['status' => 0]);
        }

        return \true;
    }
}
