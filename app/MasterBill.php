<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterBill extends Model
{
    protected $guarded = [];
    
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function detailMasterBills()
    {
        return $this->hasMany(DetailMasterBill::class, 'masterBill_id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($masterBill){ //sebelum delete data parent, hapus dulu data childnya
            $masterBill->detailMasterBills()->delete();
        });
    }
}
