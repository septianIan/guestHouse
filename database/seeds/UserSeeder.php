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
        $reservation = User::create([
            'name' => 'Reservation',
            'email' => 'reservation@gh.test',
            'password' => bcrypt(12345),
        ]);

        $reservation->assignRole('frontOffice');

        $reception = User::create([
            'name' => 'Reception',
            'email' => 'reception@gh.test',
            'password' => bcrypt(12345),
        ]);

        $reception->assignRole('frontOffice');

        $cashier = User::create([
            'name' => 'Cashier',
            'email' => 'cashier@gh.test',
            'password' => bcrypt(12345),
        ]);

        $cashier->assignRole('frontOffice');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gh.test',
            'password' => bcrypt(12345)
        ]);

        $admin->assignRole('admin');
    }
}
