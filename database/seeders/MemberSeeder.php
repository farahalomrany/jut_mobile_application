<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Member::create([
            'classification' => "gold",
            'work' => 'engineer',

        ]);

        Member::create([
            'classification' => "silver",
            'work' => 'painter',

        ]);

        Member::create([
            'classification' => "platinum",
            'work' => 'contractor',

        ]);
    

      


    }
}
