<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'phone_number' => "963948858334",
            'fstName' => 'ahmad',
            'lstName' => 'mohammad',
            'is_active' => '1',
            'city_id' => '1', 
            'password' => bcrypt('12345678'),
            'role_id' => '2', 
            'userable_type' => 'member', 
            'userable_id' => '1', 

        ]);

        User::create([
            'phone_number' => "963948858336",
            'fstName' => 'manar',
            'lstName' => 'sahow',
            'is_active' => '1',
            'city_id' => '1', 
            'password' => bcrypt('12345678'),
            'role_id' => '2', 
            'userable_type' => 'observer', 
            'userable_id' => '1', 

        ]);

        User::create([
            'phone_number' => "963948858339",
            'fstName' => 'ali',
            'lstName' => 'mohammad',
            'is_active' => '1',
            'city_id' => '1', 
            'password' => bcrypt('12345678'),
            'role_id' => '2', 
            'userable_type' => 'distributor', 
            'userable_id' => '1', 

        ]);

      


    }
}
