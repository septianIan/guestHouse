<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndividualReservationRoom extends Model
{
    use  SoftDeletes;
    protected $guarded = [];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
