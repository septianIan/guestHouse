<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestBill extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
