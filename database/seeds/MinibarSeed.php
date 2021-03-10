<?php

use App\Orderr;
use App\OrderrDetail;
use App\Product;
use Illuminate\Database\Seeder;

class MinibarSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create product
        $product = [
            [
                'name' => 'roti bakar',
                'price' => 30000,
            ],
            [
                'name' => 'Nasi goreng sea food',
                'price' => 50000,
            ],
            [
                'name' => 'Steak',
                'price' => 75000,
            ]
        ];
        Product::insert($product);
        
        //create order
        $orderr = [
            [
                'name' => 'septian aditama',
                'room_id' => 1,
                'department' => 'House keeping',
                'total' => 30000,
                'date' => 2021-03-06,
                'created_at' => '2021-06-05 12:46:52'
            ]
        ];
        Orderr::insert($orderr);

        //order details
        $orderDetail = [
            [
                'orderr_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'unitprice' => 1,
                'amount' => 60000
            ],
            [
                'orderr_id' => 1,
                'product_id' => 2,
                'quantity' => 2,
                'unitprice' => 1,
                'amount' => 100000
            ]
        ];
        OrderrDetail::insert($orderDetail);
    }
}
