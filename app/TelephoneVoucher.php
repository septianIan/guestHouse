<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelephoneVoucher extends Model
{
    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
