<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CityInx;

class CityInxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        CityInx::create([
            'name' => "Damascus",
        ]);

        CityInx::create([
            'name' => "Homs",
        ]);

        CityInx::create([
            'name' => "Aleppo",
        ]);
      
        CityInx::create([
            'name' => "Hama",
        ]);

    }
}
