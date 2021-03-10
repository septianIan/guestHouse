<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Group reservation checkIn detail
 */

class ReservationGroupCheckInDetail extends Model
{
    protected $table = 'reservation_group_check_in_details';
    protected $guarded = [];
    
    public function reservationGroup()
    {
        return $this->belongsTo(ReservationGroup::class, 'reservationgroup_id');
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
