<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distributor;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Distributor::create([
            'name' => "mar",
            'address' => 'Hama',

        ]);

        Distributor::create([
            'name' => "ler",
            'address' => 'Homs',

        ]);

        Distributor::create([
            'name' => "eng",
            'address' => 'Damas',

        ]);
    

      


    }
}
