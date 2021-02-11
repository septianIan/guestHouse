<?php

use App\IndividualReservationRoom;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IndividualReservationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $reservation = [
            [
                'guestName' => 'septian aditama',
                'arrivaleDate' => '2020-09-20',
                'departureDate' => '2020-09-25',
                'mediaReservation' => 'Telephone',
                'methodPayment' => 'debit',
                'numberAccount' => '65273471438',
                'deposit' => '100000',
                'contactPerson' => '087535252643',
                'address' => 'Jl monginsidi no 25 bojoneogoro',
                'estimateArrivale' => '09:00',
                'specialRequest' => 'no req',
                'status' => 'confirm',
                'created_at' => $date,
                'updated_at' => $date,
                //'deleted_at' => null
            ],    
            [
                'guestName' => 'andik ikwanni sowa maulidan',
                'arrivaleDate' => '2020-09-21',
                'departureDate' => '2020-09-25',
                'mediaReservation' => 'Telephone',
                'methodPayment' => 'cast',
                'numberAccount' => 0,
                'deposit' => '200000',
                'contactPerson' => '081862426234',
                'address' => 'Ds bendo kec kapas bojonegoro',
                'estimateArrivale' => '07:00',
                'specialRequest' => 'no req',
                'status' => 'confirm',
                'created_at' => $date,
                'updated_at' => $date,
                //'deleted_at' => null
            ],
            [
                'guestName' => 'ajeng ayu nindia safira',
                'arrivaleDate' => '2020-09-22',
                'departureDate' => '2020-09-24',
                'mediaReservation' => 'Telephone',
                'methodPayment' => 'cast',
                'numberAccount' => 0,
                'deposit' => '100000',
                'contactPerson' => '081935123947',
                'address' => 'Ds semanding kapas bojonegoro',
                'estimateArrivale' => '08:00',
                'specialRequest' => 'no req',
                'status' => 'confirm',
                'created_at' => $date,
                'updated_at' => $date,
                //'deleted_at' => null
            ]
        ];

        $individualReservationDetail = [
            [
                'reservation_id' => 1,
                'totalRoomReserved' => 1,
                'typeOfRoom' => 'standart',
                'roomRate' => 100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'reservation_id' => 2,
                'totalRoomReserved' => 1,
                'typeOfRoom' => 'superior',
                'roomRate' => 300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'reservation_id' => 2,
                'totalRoomReserved' => 1,
                'typeOfRoom' => 'standart',
                'roomRate' => 100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'reservation_id' => 3,
                'totalRoomReserved' => 3,
                'typeOfRoom' => 'deluxe',
                'roomRate' => 200000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservation_id' => 3,
                'totalRoomReserved' => 1,
                'typeOfRoom' => 'extraBad',
                'roomRate' => 50000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Reservation::insert($reservation);
        IndividualReservationRoom::insert($individualReservationDetail);
    }
}
