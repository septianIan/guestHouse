<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderr extends Model
{
    protected $guarded = [];

	protected $fillable = [
        'name', 'room_id', 'department', 'date', 'total'
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
