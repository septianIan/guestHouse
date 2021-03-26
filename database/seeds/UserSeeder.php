<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Reservation shift 1',
                'email' => 'reservation1@gh.test',
                'password' => bcrypt(12345),
            ],

            [
                'name' => 'Reservation shift 2',
                'email' => 'reservation2@gh.test',
                'password' => bcrypt(12345),
            ],

            [
                'name' => 'Reservation shift 3',
                'email' => 'reservation3@gh.test',
                'password' => bcrypt(12345),
            ],
        ];
        foreach($data as $dt){
            $reservation = User::create($dt);
            $reservation->assignRole('frontOffice');
        }

        // $reception = User::create([
        //     'name' => 'Reception',
        //     'email' => 'reception@gh.test',
        //     'password' => bcrypt(12345),
        // ]);

        // $reception->assignRole('frontOffice');

        // $cashier = User::create([
        //     'name' => 'Cashier',
        //     'email' => 'cashier@gh.test',
        //     'password' => bcrypt(12345),
        // ]);

        // $cashier->assignRole('frontOffice');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gh.test',
            'password' => bcrypt(12345)
        ]);

        $admin->assignRole('admin');
    }
}
