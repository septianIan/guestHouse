<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    public function rooms()
    {
        return $this->belongsToMany(Room::class)->withTimestamps();
    }

    public function getStatusReservation()
    {
        if ($this->status == 1) {
            return 'Confirm';
        } elseif ($this->status == 2) {
            return 'Tentative';
        } elseif ($this->status == 3) {
            return 'Changed';
        } else {
            return \false;
        }
    }

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

    public function individualReservations()
    {
        return $this->hasMany(IndividualReservationRoom::class);
    }
}
