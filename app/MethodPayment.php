<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MethodPayment extends Model
{
    /** 
     * PERSONAL
     * 'reservationgroup_id' => $reservationGroup->id,
        'methodPayment' => $request->methodPayment,
        'deposit' => $request->deposit,
        'value1' => $request->creditCard,
        'value2' => $request->numberAccount,
        'value3' => $requestOther,
        'status' => 0

        COMPANY
        'reservationgroup_id' => $reservationGroup->id,
        'methodPayment' => $request->methodPayment,
        'deposit' => $request->deposit,
        'value1' => $request->guarantee,
        'value2' => $request->voucher,
        'value3' => $requestOther,
        'status' => 0
     */
    public $table = 'methodpayment';
    protected $guarded = [];

    public function reservationGroup()
    {
        return $this->belongsTo(ReservationGroup::class);
    }
}
