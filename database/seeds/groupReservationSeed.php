<?php

use App\GroupReservationRoom;
use App\MethodPayment;
use App\ReservationGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class groupReservationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $groupReservation = [
            [
                'groupName' => 'PT. indomarco TBK',
                'arrivaleDate' => '2020-10-05',
                'departureDate' => '2020-10-10',
                'mediaReservation' => 'telephone',
                'contactPerson' => '082515462332',
                'addressPerson' => 'jl soekarno hatta no 12 surabaya',
                'specialRequest' => 'no req',
                'rateRequest' => 0,
                'flightNumber' => 'null',
                'estimateArrivale' => '08:00',
                'dateReservation' => $date,
                'status' => 'confirm',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null
            ],

            [
                'groupName' => 'Cv embrio technology center',
                'arrivaleDate' => '2020-10-10',
                'departureDate' => '2020-10-20',
                'mediaReservation' => 'telephone',
                'contactPerson' => '0812632648237',
                'addressPerson' => 'ds ngumpak dalem kec.dander kab. bojonegoro',
                'specialRequest' => 'jemput di terminal 12:00',
                'rateRequest' => 80000,
                'flightNumber' => '090909',
                'estimateArrivale' => '12:30',
                'dateReservation' => $date,
                'status' => 'confirm',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null
            ],

            [
                'groupName' => 'karang taruna ds pujon kidul',
                'arrivaleDate' => '2020-10-06',
                'departureDate' => '2020-10-10',
                'mediaReservation' => 'telephone',
                'contactPerson' => '083627587542',
                'addressPerson' => 'ds pujon kidol , malang',
                'specialRequest' => 'no req',
                'rateRequest' => 0,
                'flightNumber' => 'null',
                'estimateArrivale' => '08:00',
                'dateReservation' => $date,
                'status' => 'confirm',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null
            ],
        ];
        //
        $groupReservationRoom = [
            [
                'reservationgroup_id' => 1,
                'totalRoomReserved' => 10,
                'typeOfRoom' => 'standart',
                'roomRate' => 100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservationgroup_id' => 1,
                'totalRoomReserved' => 10,
                'typeOfRoom' => 'superior',
                'roomRate' => 300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservationgroup_id' => 2,
                'totalRoomReserved' => 5,
                'typeOfRoom' => 'standart',
                'roomRate' => 100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservationgroup_id' => 2,
                'totalRoomReserved' => 6,
                'typeOfRoom' => 'superior',
                'roomRate' => 300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservationgroup_id' => 3,
                'totalRoomReserved' => 15,
                'typeOfRoom' => 'standart',
                'roomRate' => 100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        $methodPayment = [
            [
                'reservationgroup_id' => 1,
                'methodPayment' => 'company',
                'deposit' => 1000000,
                'value1' => 'sertifikat perusahaan',
                'value2' => 725374173,
                'value3' => 'nothing',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservationgroup_id' => 2,
                'methodPayment' => 'personal',
                'deposit' => 200000,
                'value1' => 'credit',
                'value2' => '537246487534',
                'value3' => 'nothing',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservationgroup_id' => 3,
                'methodPayment' => 'personal',
                'deposit' => 200000,
                'value1' => 'debit',
                'value2' => '3986289642',
                'value3' => 'nothing',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        $mealsArragement = [
            [
                'reservationgroup_id' => 1,
                'meal_id' => 3,
                'atTime' => '19:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservationgroup_id' => 1,
                'meal_id' => 3,
                'atTime' => '19:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        ReservationGroup::insert($groupReservation);
        GroupReservationRoom::insert($groupReservationRoom);
        MethodPayment::insert($methodPayment);
        DB::table('reservationgroup_meal')->insert($mealsArragement);
    }
}
