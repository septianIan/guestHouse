<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
