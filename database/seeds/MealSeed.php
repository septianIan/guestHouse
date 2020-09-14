<?php

use App\Meal;
use Illuminate\Database\Seeder;

class MealSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meals = [
            [
                'type' => 'break fast',
                'price' => '50000'
            ],
            [
                'type' => 'lunc',
                'price' => '60000'
            ],
            [
                'type' => 'dinner',
                'price' => '70000'
            ],
            [
                'type' => 'coffe break',
                'price' => '40000'
            ],
        ];

        Meal::insert($meals);
    }
}
