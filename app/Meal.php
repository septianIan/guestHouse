<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $guarded = [];

    public function reservationGroups()
    {
        return $this->belongsToMany(ReservationGroup::class, 'reservationgroup_meal', 'meal_id', 'reservationgroup_id')->withTimestamps();
    }

    public function getTotalMeal()
    {
        return 'Rp. ' . \number_format($this->price, 0, ',', '.');
    }
}
