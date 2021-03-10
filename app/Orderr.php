<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderr extends Model
{
    protected $guarded = [];

	protected $fillable = [
        'name', 'room_id', 'department', 'total', 'date'
    ];
    
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function orderrdetails()
    {
        return $this->hasMany(OrderrDetail::class);
    }
}
