<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupReservationRoom extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function groupReservations()
    {
        return $this->belongsToMany(ReservationGroup::class);
    }
}
