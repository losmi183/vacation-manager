<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['id' => 1, 'name' => 'Administrator']);
        Role::create(['id' => 2, 'name' => 'Menadzer']);
        Role::create(['id' => 3, 'name' => 'Korisnik']);
    }
}
