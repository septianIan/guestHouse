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
    protected $table = 'drycleaning_details';
    protected $fillable = [
        'drycleanings_id', 'package_id', 'quantity', 'unitprice', 'amount'
    ];

    public function drycleanings()
    {
    	return $this->belongsTo(Drycleanings::class);
    }

     public function package(){
    	return $this->belongsTo(Packages::class);
    }
}
