<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    //use SoftDeletes;
    
    protected $guarded = [];

    public function getTotalRp()
    {
        return 'Rp. '. \number_format($this->total, 0, ',', '.');
    }

    public function setArrivaleDateAttribute($value)
    {
        $this->attributes['arrivaleDate'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    public function setDepartureDateAttribute($value)
    {
        $this->attributes['departureDate'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    public function individualReservationRooms()
    {
        return $this->hasMany(IndividualReservationRoom::class);
    }

    public function delete()
    {
        $this->individualReservationRooms()->delete();
        parent::delete();
    }
}
