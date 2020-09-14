<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MethodPayment extends Model
{
    public $table = 'methodpayment';
    protected $guarded = [];

    public function reservationGroup()
    {
        return $this->belongsTo(ReservationGroup::class);
    }
}
