<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drycleanings extends Model
{
    protected $guarded = [];

	protected $fillable = [
        'name', 'room_id', 'total', 'date'
    ];
    
    public function room()
    {
    	return $this->belongsTo(Room::class);
    }

    public function drycleaning_details()
    {
    	return $this->hasMany(DrycleaningDetails::class, 'drycleaning_id', 'id');
    }
}
