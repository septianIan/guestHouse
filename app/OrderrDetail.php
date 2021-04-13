<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderrDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orderr_id', 'product_id', 'quantity', 'unitprice', 'amount'
    ];

    public function orderr()
    {
        return $this->belongsTo(Orderr::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
