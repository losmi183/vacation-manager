<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TeamRepository
{
    public function store(array $data): Team {
        try {
            $team = Team::create($data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, 'Team could not be created');        
        }
        return $team;
    }
   
}