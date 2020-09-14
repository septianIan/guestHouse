<?php

use App\MasterLaundry;
use Illuminate\Database\Seeder;

class MasterLaundrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masterLaundries = [
            [
                'serviceLaundry' => 'cuci kering',
                'price' => '3000'
            ],
            [
                'serviceLaundry' => 'cuci strika',
                'price' => '5000'
            ],
        ];

        MasterLaundry::insert($masterLaundries);
    }
}
