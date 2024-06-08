<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('admin'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'menadzer1',
            'email' => 'menadzer1@localhost',
            'password' => bcrypt('menadzer1'),
            'role_id' => 2
        ]);
        User::create([
            'name' => 'menadzer2',
            'email' => 'menadzer2@localhost',
            'password' => bcrypt('menadzer2'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'korisnik1',
            'email' => 'korisnik1@localhost',
            'team_id' => 1,
            'password' => bcrypt('korisnik1'),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'korisnik2',
            'email' => 'korisnik2@localhost',
            'team_id' => 1,
            'password' => bcrypt('korisnik2'),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'korisnik3',
            'email' => 'korisnik3@localhost',
            'team_id' => 2,
            'password' => bcrypt('korisnik3'),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'korisnik4',
            'email' => 'korisnik4@localhost',
            'team_id' => 2,
            'password' => bcrypt('korisnik4'),
            'role_id' => 3
        ]);
    }
}
