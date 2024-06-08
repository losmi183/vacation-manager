<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::create([
            'id' => 1,
            'name' => 'Team 1',
        ]);
        Team::create([
            'id' => 2,
            'name' => 'Team 2',
        ]);
    }
}
