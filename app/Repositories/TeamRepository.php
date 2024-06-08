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

    public function assignUser(array $data): User 
    {
        try {
            $user = User::find($data['user_id']);
            $user->team_id = $data['team_id'];
            $user->save();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, 'Team could not be created');        
        }
        return $user;
    }

    public function teamManager(array $data): User 
    {
        try {
            // Start transaction
            DB::beginTransaction();

            $user = User::find($data['user_id']);
            $roles = config('settings.roles');
            // Delete all previous tema_manager for user
            DB::table('team_manager')->where('user_id', $data['user_id'])->delete();

            // Assigning user as team manager to array
            if(count($data['teams']) > 0) {
                foreach ($data['teams'] as $team) {
                    DB::table('team_manager')->insert([
                        'user_id' => $data['user_id'],
                        'team_id' => $team
                    ]);
                }                
                $user->role_id = $roles['Menadzer'];
                $user->save();
                // End transaction - commit new state
                DB::commit();
                $user->teams_manager = $data['teams'];
            } else {
                DB::rollBack();
                $user->role_id = $roles['Korisnik'];
                $user->save();
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, 'User can not be assigned as team manager');        
        }
        return $user;
    }
   
}