<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Observer;

class ObserverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Observer::create([
            'id' => "1",
            

        ]);

        Observer::create([
            'id' => "2",
            

        ]);

        Observer::create([
            'id' => "3",
            

        ]);
    

      


    }
}
