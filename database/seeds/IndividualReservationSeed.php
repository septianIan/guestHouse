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
        $reservation = [
            [
                'guestName' => 'septian aditama',
                'arrivaleDate' => Carbon::now()->format('Y-m-d'),
                'departureDate' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'mediaReservation' => 'Telephone',
                'methodPayment' => 'debit',
                'numberAccount' => '65273471438',
                'deposit' => '300000',
                'contactPerson' => '087535252643',
                'address' => 'Jl monginsidi no 25 bojoneogoro',
                'estimateArrivale' => '09:00',
                'dateReservation' =>Carbon::now()->format('Y-m-d'),
                'specialRequest' => 'no req',
                'clerk' => 'Reservation shift 1',
                'status' => 'checkIn',
                'created_at' =>Carbon::now()->format('Y-m-d'),
                'updated_at' =>Carbon::now()->format('Y-m-d'),
                //'deleted_at' => null
            ],    
            [
                'guestName' => 'ajeng ayu nindia safira',
                'arrivaleDate' => Carbon::now()->addDays(-2)->format('Y-m-d'),
                'departureDate' => Carbon::now()->format('Y-m-d'),
                'mediaReservation' => 'Telephone',
                'methodPayment' => 'transfer',
                'numberAccount' => '65273471438',
                'deposit' => '300000',
                'contactPerson' => '087535252643',
                'address' => 'Jl patimura no 25 bojoneogoro',
                'estimateArrivale' => '08:00',
                'dateReservation' => Carbon::now()->addDays(-2)->format('Y-m-d'),
                'specialRequest' => 'no req',
                'clerk' => 'Reservation shift 1',
                'status' => 'checkIn',
                'created_at' =>Carbon::now()->format('Y-m-d'),
                'updated_at' =>Carbon::now()->format('Y-m-d'),
                //'deleted_at' => null
            ],
            [
                'guestName' => 'Bayu aji',
                'arrivaleDate' => Carbon::now()->addDays(-2)->format('Y-m-d'),
                'departureDate' => Carbon::now()->format('Y-m-d'),
                'mediaReservation' => 'Telephone',
                'methodPayment' => 'credit',
                'numberAccount' => '65273471438',
                'deposit' => '300000',
                'contactPerson' => '087535252643',
                'address' => 'Jl basuki rahmat no 25 bojoneogoro',
                'estimateArrivale' => '15:00',
                'dateReservation' => Carbon::now()->addDays(-2)->format('Y-m-d'),
                'specialRequest' => 'no req',
                'clerk' => 'Reservation shift 1',
                'status' => 'confirm',
                'created_at' =>Carbon::now()->format('Y-m-d'),
                'updated_at' =>Carbon::now()->format('Y-m-d'),
                //'deleted_at' => null
            ],
        ];

        $individualReservationDetail = [
            [
                'reservation_id' => 1,
                'totalRoomReserved' => 1,
                'totalPax' => 2,
                'typeOfRoom' => 'standart',
                'roomRate' => 200000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'reservation_id' => 2,
                'totalRoomReserved' => 1,
                'totalPax' => 2,
                'typeOfRoom' => 'superior',
                'roomRate' => 300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'reservation_id' => 2,
                'totalRoomReserved' => 1,
                'totalPax' => 2,
                'typeOfRoom' => 'standart',
                'roomRate' => 200000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'reservation_id' => 3,
                'totalRoomReserved' => 1,
                'totalPax' => 2,
                'typeOfRoom' => 'standart',
                'roomRate' => 200000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Reservation::insert($reservation);
        IndividualReservationRoom::insert($individualReservationDetail);
    }
}
