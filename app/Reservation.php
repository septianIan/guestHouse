<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    public function rooms()
    {
        return $this->belongsToMany(Room::class)->withTimestamps();
    }

    public function getStatusReservation()
    {
        if ($this->status == 0) {
            return 'Not reserved';
        }
    }

    public function getTotalRp()
    {
        return 'Rp. '. \number_format($this->total, 0, ',', '.');
    }
}
