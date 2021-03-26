<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailMasterBill extends Model
{
    protected $guarded = [];

    public function masterBill()
    {
        return $this->belongsTo(MasterBill::class, 'masterBill_id');
    }
}
