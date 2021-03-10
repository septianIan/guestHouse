<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrycleaningDetails extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'drycleaning_id', 'package_id', 'quantity', 'unitprice', 'amount'
    ];

    public function drycleanings()
    {
        return $this->belongsTo(Drycleanings::class, 'drycleaning_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }
}
