<?php

use App\CheckIn;
use App\Registration;
use App\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegistrationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $data = [
            [
                'firstName' => 'Adam',
                'lastName' => 'budi',
                'nationality' => 'ID',
                'passport' => '123',
                'occupation' => 'mahasiswa',
                'dateBirth' => '1998-09-26',
                'homeAddress' => 'Lamongan jawa timur indonesia',
                'company' => 'no',
                'purpose' => 'batu malang',
                'arrivaleDate' => Carbon::now()->format('Y-m-d'),
                'departureDate' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'comingFrom' => 'surabaya',
                'nextDestination' => 'tuban',
                'termOfPayment' => 'creditCard',
                'numberAccount' => '9823874982',
                // 'expDate' => '2022-10-20',
                'status' => 'checkIn',
                'created_at' => $date,            
                'updated_at' => $date            
            ],

            [
                'firstName' => 'ajeng',
                'lastName' => 'ayu nindia safira',
                'nationality' => 'ID',
                'passport' => '123',
                'occupation' => 'mahasiswa',
                'dateBirth' => '1998-09-26',
                'homeAddress' => 'bojonegoro jawa timur indonesia',
                'company' => 'no',
                'purpose' => 'batu malang',
                'arrivaleDate' => Carbon::now()->addDays(-2)->format('Y-m-d'),
                'departureDate' => Carbon::now()->format('Y-m-d'),
                'comingFrom' => 'surabaya',
                'nextDestination' => 'tuban',
                'termOfPayment' => 'creditCard',
                'numberAccount' => '9823874982',
                // 'expDate' => '2022-10-20',
                'status' => 'checkIn',
                'created_at' => $date,            
                'updated_at' => $date            
            ],

            [
                'firstName' => 'andi',
                'lastName' => 'ikwanu sofa maulidan',
                'nationality' => 'ID',
                'passport' => '123343545',
                'occupation' => 'pegawai',
                'dateBirth' => '1998-09-26',
                'homeAddress' => 'bojonegoro jawa timur indonesia',
                'company' => 'no',
                'purpose' => 'batu malang',
                'arrivaleDate' => Carbon::now()->format('Y-m-d'),
                'departureDate' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'comingFrom' => 'surabaya',
                'nextDestination' => 'tuban',
                'termOfPayment' => 'creditCard',
                'numberAccount' => '9823874982',
                // 'expDate' => '2022-10-20',
                'status' => 'checkIn',
                'created_at' => $date,            
                'updated_at' => $date            
            ],
        ];

        $regisRoom = [
            [
                'registration_id' => 1,
                'room_id' => 1,
                'totalPax' => 2,
                'roomRate' => 200000,
                'typeOfRegistration' => 'individual',
                'walkInOrReservation' => 'walk in',
                'created_at' => $date,
                'updated_at' => $date
            ],
            
            [
                'registration_id' => 2,
                'room_id' => 7,
                'totalPax' => 2,
                'roomRate' => 300000,
                'typeOfRegistration' => 'individual',
                'walkInOrReservation' => 'reservation',
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'registration_id' => 2,
                'room_id' => 4,
                'totalPax' => 2,
                'roomRate' => 200000,
                'typeOfRegistration' => 'individual',
                'walkInOrReservation' => 'reservation',
                'created_at' => $date,
                'updated_at' => $date
            ],

            [
                'registration_id' => 3,
                'room_id' => 6,
                'totalPax' => 2,
                'roomRate' => 300000,
                'typeOfRegistration' => 'group',
                'walkInOrReservation' => 'reservation',
                'created_at' => $date,
                'updated_at' => $date
            ],

            [
                'registration_id' => 3,
                'room_id' => 15,
                'totalPax' => 2,
                'roomRate' => 400000,
                'typeOfRegistration' => 'group',
                'walkInOrReservation' => 'reservation',
                'created_at' => $date,
                'updated_at' => $date
            ],
        ];

        $dataCheckIn = [
            [
                'registration_id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'time' => '17:00',
                'status' => 0
            ],
            [
                'registration_id' => 2,
                'date' => Carbon::now()->addDays(-2)->format('Y-m-d'),
                'time' => '15:00',
                'status' => 0
            ]
        ];

        $detailReservationCheckIn = [
            [
                'reservation_id' => 2,
                'registration_id' => 2,
            ]
        ];

        $detailReservationCheckInGroup = [
            [
                'reservationgroup_id' => 1,
                'registration_id' => 3,
            ]
        ];

        //* regis by reservation
        Registration::insert($data);
        DB::table('registration_room')->insert($regisRoom);

        //* check in
        CheckIn::insert($dataCheckIn);

        DB::table('reservation_detail_check_in')->insert($detailReservationCheckIn);
        DB::table('reservation_group_check_in_details')->insert($detailReservationCheckInGroup);
        
    }
}
