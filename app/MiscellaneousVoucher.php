<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiscellaneousVoucher extends Model
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
