<?php

use App\IndividualReservationRoom;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MasterLaundrySeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(MealSeed::class);
        $this->call(IndividualReservationSeed::class);
        $this->call(groupReservationSeed::class);
    }
}
