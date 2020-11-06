<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationCheckInDetail extends Model
{
    protected $table = 'reservation_detail_check_in';
    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
