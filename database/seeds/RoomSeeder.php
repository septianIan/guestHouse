<?php

use App\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            [
                'roomType' => 'standart',
                'numberRoom' => '01',
                'price' => '200000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'standart',
                'numberRoom' => '02',
                'price' => '200000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'standart',
                'numberRoom' => '03',
                'price' => '200000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'standart',
                'numberRoom' => '04',
                'price' => '200000',
                'status' => 'VR'
            ],  
            [
                'roomType' => 'standart',
                'numberRoom' => '05',
                'price' => '200000',
                'status' => 'VR'
            ],
            //Superior
            [
                'roomType' => 'superior',
                'numberRoom' => '06',
                'price' => '300000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '07',
                'price' => '300000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '08',
                'price' => '300000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '09',
                'price' => '300000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '10',
                'price' => '300000',
                'status' => 'VR'
            ],
            //Deluxe
            [
                'roomType' => 'deluxe',
                'numberRoom' => '11',
                'price' => '400000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '12',
                'price' => '400000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '13',
                'price' => '400000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '14',
                'price' => '400000',
                'status' => 'VR'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '15',
                'price' => '400000',
                'status' => 'VR'
            ],
        ];
        Room::insert($rooms);
    }
}
