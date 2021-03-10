<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividualReservationRoom extends Model
{
    protected $guarded = [];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
