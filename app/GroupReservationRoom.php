<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupReservationRoom extends Model
{
    protected $guarded = [];

    public function groupReservations()
    {
        return $this->belongsToMany(ReservationGroup::class);
    }
}
