<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Admin::create([
            'is_super' => "1",
            

        ]);

        Admin::create([
            'is_super' => "0",
            

        ]);

        Admin::create([
            'is_super' => "1",
            
        ]);
    

      


    }
}
