<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('team_manager')->insert([
            'team_id' => 1,
            'user_id' => 2
        ]);
        DB::table('team_manager')->insert([
            'team_id' => 2,
            'user_id' => 2
        ]);
        DB::table('team_manager')->insert([
            'team_id' => 2,
            'user_id' => 3
        ]);
    }
}
