<?php

namespace Database\Seeders;

use App\Models\Request;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Request::create([
        	"date_from" => "2024-06-01",
            "date_to" => "2024-06-10",
            "type" => "vacation",
            "user_id" => 4,
            "working_days" => 6
        ]);
        Request::create([
        	"date_from" => "2024-06-24",
            "date_to" => "2024-06-24",
            "type" => "days",
            "user_id" => 4,
            "working_days" => 1
        ]);
        Request::create([
        	"date_from" => "2024-06-11",
            "date_to" => "2024-06-20",
            "type" => "vacation",
            "user_id" => 5,
            "working_days" => 8
        ]);
        Request::create([
        	"date_from" => "2024-06-01",
            "date_to" => "2024-06-10",
            "type" => "vacation",
            "user_id" => 6,
            "working_days" => 6
        ]);
    }
}
