<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomSurcharge extends Model
{
    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
