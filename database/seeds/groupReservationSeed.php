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
        $groupReservation = [
            [
                'groupName' => 'PT. indomarco TBK',
                'arrivaleDate' => Carbon::now()->format('Y-m-d'),
                'departureDate' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'mediaReservation' => 'telephone',
                'contactPerson' => 'andi ikwanu sowa maulidan',
                'addressPerson' => 'jl soekarno hatta no 12 surabaya',
                'specialRequest' => 'no req',
                'rateRequest' => 0,
                'flightNumber' => 'null',
                'estimateArrivale' => '08:00',
                'dateReservation' => Carbon::now()->format('Y-m-d'),
                'clerk' => 'Reservation shift 1',
                'status' => 'confirm',
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
                'deleted_at' => null
            ],
        ];
        //
        $groupReservationRoom = [
            [
                'reservationgroup_id' => 1,
                'totalRoomReserved' => 1,
                'typeOfRoom' => 'superior',
                'roomRate' => 300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'reservationgroup_id' => 1,
                'totalRoomReserved' => 1,
                'typeOfRoom' => 'deluxe',
                'roomRate' => 400000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        $methodPayment = [
            [
                'reservationgroup_id' => 1,
                'methodPayment' => 'company',
                'deposit' => 2000000,
                'value1' => 'sertifikat perusahaan',
                'value2' => 725374173,
                'value3' => 'nothing',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
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
                'meal_id' => 1,
                'atTime' => '07:00',
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
