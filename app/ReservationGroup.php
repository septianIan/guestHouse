<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReservationGroup extends Model
{
    public $table = 'reservationgroups';
    protected $guarded = [];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservationgroup_room',  'reservationgroup_id', 'room_id');
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'reservationgroup_meal', 'reservationgroup_id', 'meal_id')->withPivot('atTime');
    }

    public function methodPayment()
    {
        return $this->hasOne(MethodPayment::class, 'reservationgroup_id', 'id');
    }

    public function getTotalRp()
    {
        return 'Rp. '. \number_format($this->totalRoomPayment, 0, ',', '.');
    }
}
