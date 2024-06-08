<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function users(): ?Collection {

        return DB::table('users as u')
        ->leftJoin('teams as t', 't.id', '=', 'u.team_id')
        ->select('u.*', 't.name as team_name')
        ->get();
}
    public function usersPaginate(array $params): LengthAwarePaginator {

        $itemsPerPage = $params['itemsPerPage'];
        if ($params['itemsPerPage'] == -1) {
            $itemsPerPage = DB::table('users')->count();
        } 
        $page = $params['itemsPerPage'] != -1 ? $params['page'] : 1;
        $search = $params['search'];

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        return DB::table('users as u')
        ->leftJoin('teams as t', 't.id', '=', 'u.team_id')
        ->select('u.*', 't.name as team_name')
        ->when($search != '', function($q) use ($search) {
            return $q->where('users.name', 'like', '%'. $search .'%');
        })
        ->paginate($itemsPerPage);
    }

    public function store(array $data): User
    {
        try {
            $user = User::create($data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, 'User not created');
        }
        return $user;
    }

    public function update(array $data, $id): User
    {
        try {
            $user = User::find($id);
            $user->update($data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, 'User not created');
        }
        return $user;
    }
    public function userRole(array $data): User
    {
        try {
            $user = User::find($data['user_id']);
            $user->role_id = $data['role_id'];
            $user->save();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, 'User role not updated');
        }
        return $user;
    }
}