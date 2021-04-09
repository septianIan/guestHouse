<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationGroup extends Model
{
    use SoftDeletes;

    public $table = 'reservationgroups';
    protected $guarded = [];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservationgroup_room',  'reservationgroup_id', 'room_id');
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'reservationgroup_meal', 'reservationgroup_id', 'meal_id')->withPivot('atTime', 'id');
    }

    public function methodPayment()
    {
        return $this->hasOne(MethodPayment::class, 'reservationgroup_id', 'id');
    }

    public function groupCheckInDetail()
    {
        return $this->hasOne(ReservationGroupCheckInDetail::class);
    }

    public function getTotalRp()
    {
        return 'Rp. '. \number_format($this->totalRoomPayment, 0, ',', '.');
    }

    public function setArrivaleDateAttribute($value)
    {
        $this->attributes['arrivaleDate'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    public function setDepartureDateAttribute($value)
    {
        $this->attributes['departureDate'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    public function groupReservationRooms()
    {
        return $this->hasMany(GroupReservationRoom::class, 'reservationgroup_id');
    }

    public function getStatusGroupReservation()
    {
        if ($this->status == 'confirm') {
            return 'Confirm';
        } elseif ($this->status == 'tentantive') {
            return 'Tentative';
        } elseif ($this->status == 'Changed') {
            return 'Changed';
        } elseif($this->status == 'checkIn') {
            return 'Check In';
        } else {
            return \false;
        }
    }

    public function getFirstName()
    {
        // Split name
        $splitName = \explode(' ', $this->contactPerson, 2);
        $firstName = $splitName[0];
        $lastName = !empty($splitName[1]) ? $splitName[1] : '';
        return $firstName;
    }

    public function getLastName()
    {
        $splitName = \explode(' ', $this->contactPerson, 2);
        $firstName = $splitName[0];
        $lastName = !empty($splitName[1]) ? $splitName[1] : '';
        return $lastName;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($groupReservation){
            $groupReservation->update(['status' => 0]);
            $groupReservation->groupReservationRooms()->delete();
        });
    }
}
