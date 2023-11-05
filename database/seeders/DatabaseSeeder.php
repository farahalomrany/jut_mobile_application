<?php

namespace Database\Seeders;

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
        // User::factory(6)->create();
        $this->call(MemberSeeder::class);
        $this->call(ObserverSeeder::class);
        $this->call(DistributorSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CityInxSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GiftNameInxSeeder::class);
    }
}
