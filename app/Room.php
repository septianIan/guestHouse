<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function reservationGroups()
    {
        return $this->belongsToMany(ReservationGroup::class, 'reservationgroup_room', 'room_id', 'reservationgroup_id');
    }

    public function registrations()
    {
        return $this->belongsToMany(Registration::class);
    }

    public function getRoomTypeAttribute($value)
    {
        return strtoupper($value);
    }

    public function getPriceRp()
    {
        return 'Rp. ' . \number_format($this->price, 0, ',', '.');
    }

    public function telephoneBills()
    {
        return $this->hasMany(TelephoneVoucher::class);
    }
}
