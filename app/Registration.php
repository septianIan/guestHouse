<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Registration extends Model
{
    protected $guarded = [];

    public function getGuestName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class)->withPivot('id','totalPax', 'roomRate', 'typeOfRegistration', 'walkInOrReservation');
    }

    public function setArrivaleDateAttribute($value)
    {
        $this->attributes['arrivaleDate'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    public function setDepartureDateAttribute($value)
    {
        $this->attributes['departureDate'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    public function extraBad()
    {
        return $this->hasOne(ExtraBad::class);
    }

    public function masterBills()
    {
        return $this->hasMany(MasterBill::class);
    }

    public function checkIn()
    {
        return $this->hasOne(CheckIn::class);
    }

    public function checkOut()
    {
        return $this->hasOne(CheckOut::class);
    }

    public function roomSurcharge()
    {
        return $this->hasOne(RoomSurcharge::class);
    }
}
