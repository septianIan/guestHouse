<?php

use App\DrycleaningDetails;
use App\Drycleanings;
use App\Packages;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LaundrySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataPackage = [
            [
                'name' => 'celana jeans',
                'price' => 25000,
            ],
            [
                'name' => 'suits',
                'price' => 15000,
            ],
            [
                'name' => 't shirst',
                'price' => 10000,
            ],
            [
                'name' => 'Jacket',
                'price' => 20000,
            ]
        ];
        DB::table('packages')->insert($dataPackage);

        $drycleanings = [
            [
                'name' => 'Adam',
                'room_id' => 1,
                'total' => 35000,
                'date' => Carbon::now()->addDays(1)->format('Y-m-d')
            ],
            [
                'name' => 'ajeng ayu nindia safira',
                'room_id' => 7,
                'total' => 50000,
                'date' => Carbon::now()->addDays(-1)->format('Y-m-d')
            ]
        ];
        Drycleanings::insert($drycleanings);

        $drycleaningDetail = [
            [
                'drycleanings_id' => 1,
                'package_id' => 1,
                'quantity' => 1,
                'unitprice' => 1,
                'amount' => 25000,
            ],
            [
                'drycleanings_id' => 1,
                'package_id' => 1,
                'quantity' => 1,
                'unitprice' => 1,
                'amount' => 10000,
            ],
            [
                'drycleanings_id' => 2,
                'package_id' => 1,
                'quantity' => 1,
                'unitprice' => 1,
                'amount' => 25000,
            ],
            [
                'drycleanings_id' => 2,
                'package_id' => 2,
                'quantity' => 1,
                'unitprice' => 1,
                'amount' => 15000,
            ],
            [
                'drycleanings_id' => 2,
                'package_id' => 3,
                'quantity' => 1,
                'unitprice' => 1,
                'amount' => 10000,
            ],
        ];
        DrycleaningDetails::insert($drycleaningDetail);
    }
}
