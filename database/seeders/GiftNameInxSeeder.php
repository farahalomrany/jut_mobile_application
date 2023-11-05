<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GiftNameInx;

class GiftNameInxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        GiftNameInx::create([
            'name' => "hat",
            'description' => "fhfhf",
        ]);

        GiftNameInx::create([
            'name' => "address",
            'description' => "fhfhf",
        ]);

        GiftNameInx::create([
            'name' => "makeup",
            'description' => "fhfhf",
        ]);
      

    }
}
