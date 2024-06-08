<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
}