<?php

use App\Orderr;
use App\OrderrDetail;
use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => 'Coca cola',
                'price' => 20000,
            ],
            [
                'name' => 'Ice latte',
                'price' => 20000,
            ],
            [
                'name' => 'Green milk',
                'price' => 15000,
            ]
        ];
        DB::table('products')->insert($product);
        
        //create order
        $orderr = [
            [
                'name' => 'adam',
                'room_id' => 1,
                'department' => 'House keeping',
                'total' => 30000,
                'date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'created_at' => Carbon::today()
            ],
            [
                'name' => 'Ajeng ayu',
                'room_id' => 4,
                'department' => 'House keeping',
                'total' => 30000,
                'date' => Carbon::now()->addDays(-1)->format('Y-m-d'),
                'created_at' => Carbon::today()
            ]
        ];
        DB::table('orderrs')->insert($orderr);

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
            ],
            [
                'orderr_id' => 2,
                'product_id' => 2,
                'quantity' => 2,
                'unitprice' => 1,
                'amount' => 200000
            ]
        ];
        DB::table('orderr_details')->insert($orderDetail);
    }
}
