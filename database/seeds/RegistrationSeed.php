<?php

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
                'firstName' => 'septian',
                'lastName' => 'aditama',
                'nationality' => 'ID',
                'passport' => '123',
                'occupation' => 'mahasiswa',
                'dateBirth' => '1998-09-26',
                'homeAddress' => 'bojongoro jawa timur indonesia',
                'company' => 'no',
                'purpose' => 'batu malang',
                'arrivaleDate' => '2020-10-17',
                'departureDate' => '2020-10-20',
                'comingFrom' => 'surabaya',
                'nextDestination' => 'tuban',
                'termOfPayment' => 'creditCard',
                'numberAccount' => '9823874982',
                // 'expDate' => '2022-10-20',
                'status' => 'confirm',
                'created_at' => $date,            
                'updated_at' => $date            
            ],

            [
                'firstName' => 'ian',
                'lastName' => 'marmoyo',
                'nationality' => 'ID',
                'passport' => '1232323',
                'occupation' => 'mahasiswa',
                'dateBirth' => '1988-03-26',
                'homeAddress' => 'bojongoro jawa timur indonesia',
                'company' => 'no',
                'purpose' => 'batu malang',
                'arrivaleDate' => '2020-10-30',
                'departureDate' => '2020-11-05',
                'comingFrom' => 'surabaya',
                'nextDestination' => 'tuban',
                'termOfPayment' => 'creditCard',
                'numberAccount' => '9823874982',
                // 'expDate' => '2022-10-20',
                'status' => 'confirm',
                'created_at' => $date,            
                'updated_at' => $date            
            ],
        ];

        $regisRoom = [
            [
                'registration_id' => 1,
                'room_id' => 1,
                'totalPax' => 2,
                'roomRate' => 100000,
                'typeOfRegistration' => 'individual',
                'walkInOrReservation' => 'walkIn',
                'created_at' => $date,
                'updated_at' => $date
            ],

            [
                'registration_id' => 2,
                'room_id' => 2,
                'totalPax' => 2,
                'roomRate' => 100000,
                'typeOfRegistration' => 'individual',
                'walkInOrReservation' => 'walkIn',
                'created_at' => $date,
                'updated_at' => $date
            ],

            [
                'registration_id' => 2,
                'room_id' => 3,
                'totalPax' => 2,
                'roomRate' => 100000,
                'typeOfRegistration' => 'individual',
                'walkInOrReservation' => 'walkIn',
                'created_at' => $date,
                'updated_at' => $date
            ],
            
        ];

        Registration::insert($data);
        DB::table('registration_room')->insert($regisRoom);
    }
}
