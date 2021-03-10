<?php

use App\DrycleaningDetails;
use App\Drycleanings;
use App\Packages;
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
        Packages::insert($dataPackage);

        $drycleanings = [
            [
                'name' => 'septian aditama',
                'room_id' => 1,
                'total' => 35000,
                'date' => '2021-03-05'
            ]
        ];
        Drycleanings::insert($drycleanings);

        $drycleaningDetail = [
            [
                'drycleaning_id' => 1,
                'package_id' => 1,
                'quantity' => 1,
                'unitprice' => 1,
                'amount' => 25000,
            ],
            [
                'drycleaning_id' => 1,
                'package_id' => 1,
                'quantity' => 1,
                'unitprice' => 1,
                'amount' => 10000,
            ],
        ];
        DrycleaningDetails::insert($drycleaningDetail);
    }
}
