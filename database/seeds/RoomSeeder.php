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
                'numberRoom' => '101',
                'price' => '200000',
                'code' => 'O'
            ],
            [
                'roomType' => 'standart',
                'numberRoom' => '102',
                'price' => '200000',
                'code' => 'O'
            ],
            [
                'roomType' => 'standart',
                'numberRoom' => '103',
                'price' => '200000',
                'code' => 'O'
            ],
            [
                'roomType' => 'standart',
                'numberRoom' => '104',
                'price' => '200000',
                'code' => 'VR'
            ],  
            [
                'roomType' => 'standart',
                'numberRoom' => '105',
                'price' => '200000',
                'code' => 'VR'
            ],
            //Superior
            [
                'roomType' => 'superior',
                'numberRoom' => '106',
                'price' => '300000',
                'code' => 'VR'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '107',
                'price' => '300000',
                'code' => 'VR'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '108',
                'price' => '300000',
                'code' => 'VC'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '109',
                'price' => '300000',
                'code' => 'VR'
            ],
            [
                'roomType' => 'superior',
                'numberRoom' => '110',
                'price' => '300000',
                'code' => 'VC'
            ],
            //Deluxe
            [
                'roomType' => 'deluxe',
                'numberRoom' => '111',
                'price' => '400000',
                'code' => 'VR'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '112',
                'price' => '400000',
                'code' => 'VD'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '113',
                'price' => '400000',
                'code' => 'VR'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '114',
                'price' => '400000',
                'code' => 'VD'
            ],
            [
                'roomType' => 'deluxe',
                'numberRoom' => '115',
                'price' => '400000',
                'code' => 'VR'
            ],
        ];
        Room::insert($rooms);
    }
}
