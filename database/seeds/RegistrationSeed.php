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
                'roomRate' => 200000,
                'typeOfRegistration' => 'individual',
                'walkInOrReservation' => 'reservation',
                'created_at' => $date,
                'updated_at' => $date
            ],            
        ];

        Registration::insert($data);
        DB::table('registration_room')->insert($regisRoom);
    }
}
