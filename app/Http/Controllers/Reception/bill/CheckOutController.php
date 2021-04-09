<?php

namespace App\Http\Controllers\Reception\bill;

use App\CheckOut;
use App\DetailMasterBill;
use App\GuestBill;
use App\Http\Controllers\Controller;
use App\MasterBill;
use App\Registration;
use App\ReservationCheckInDetail;
use App\ReservationGroupCheckInDetail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{   
    public $id;
    public function getId($id)
    {
        return $id;
    }

    public function checkEarlyDeparture($id)
    {
        $jamSekarang = Carbon::now()->toTimeString();
        $jamDuaBelasSiang = Carbon::now()->format('12:00');
        // jika check out lebih dari jam 12 siang maka akan di kenakan biaya tambahan
        if ($jamSekarang > $jamDuaBelasSiang) {
            //jika melebihi di kenakan charge
            $success = \true;
            $message = 'Guests will be charged an additional fee, because check-in is before 12pm !';
        } else {
            $success = \false; //jika tidak lanjut ke check in
            $message = '';
        }
        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function checkOut($id)
    {   
        $this->getId($id);
        //!jika masih ada data yang statusnya 0
        if ($this->getTemporaryBills($id)->isEmpty()) {
            $status = 1;
            $message = 'Make sure the master has been created';
        } elseif($this->getCheckStatusTemporaryBills($id)->isNotEmpty()){
            $status = 2;
            $message = 'The room bill as of the present date has not been paid';
        } else {
            CheckOut::create([
                'registration_id' => $id,
                'date' => Carbon::now()->format('Y-m-d'),
                'time' => Carbon::now()->format('H:i:s')
            ]);
            $this->updateStatusCheckOut($id);
            $status = 3;
            $message = 'oke';
        }

        return \response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function getTemporaryBills($id)
    {
        $temporaryBills = DB::table('temporary_bills')->where('registration_id', $this->getId($id))->get();

        return $temporaryBills;
    }

    public function getCheckStatusTemporaryBills($id)
    {
        $registration = Registration::find($this->getId($id));
        $checkIn = Carbon::parse($registration->arrivaleDate); //11-03-2021 maju 1 tanggal
        $toDay = Carbon::now()->format('Y-m-d');
        $checkStatusTemporaryBills = '';
        $checkStatusTemporaryBills = DB::table('temporary_bills')->whereBetween('date', [$checkIn, $toDay])->where([
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
        $guestWalkIn = Registration::findOrFail($this->getId($id));
        $guestWalkIn->update(['status' => 'checkOut']);
        
        return \true;
    }

    // public function checkOutDetail($id)
    // {
    //     $this->dataCheckOut($id);
    //     if ($this->dataCheckOut($id)) {
    //         return view("frontOffice.reception.detail", [
    //             'registrationCheckOut' => $this->dataCheckOut($id),
    //             'difference' => $this->difference($id),
    //             'guestIndividaulReservation' => $this->guestIndividaulReservation($id),
    //             'guestGroupReservation' => $this->guestGroupReservation($id),
    //         ]);
    //     } else {
    //         return \abort(404);
    //     }
    // }

    // public function dataCheckOut($id)
    // {
    //     $registrationCheckOut = CheckOut::where('registration_id', $id)->first();
    //     return $registrationCheckOut;
    // }

    // public function guestIndividaulReservation($id)
    // {   
    //     $guestIndividaulReservation = ReservationCheckInDetail::where('registration_id', $this->dataCheckOut($id)->registration_id)
    //     ->first();
    //     return $guestIndividaulReservation;
    // }

    // public function guestGroupReservation($id)
    // {
    //     $guestGroupReservation = ReservationGroupCheckInDetail::where('registration_id', $this->dataCheckOut($id)->registration_id)
    //     ->first();      
    //     return $guestGroupReservation;
    // }

    // public function difference($id)
    // {   
    //     $dataCheckOut = $this->dataCheckOut($id);
    //     $checkIn = new Carbon($dataCheckOut->registration->arrivaleDate);
    //     $checkOut = $dataCheckOut->registration->departureDate;
    //     $difference = ($checkIn->diff($checkOut)->days < -1)
    //         ? 'today'
    //         : $checkIn->diffInDays($checkOut);

    //     return $difference;
    // }
}
