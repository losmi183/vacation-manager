<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function users(): Collection {

        return User::all();
    }
    public function usersPaginate(array $params): LengthAwarePaginator {

        $itemsPerPage = $params['itemsPerPage'];
        if ($params['itemsPerPage'] == -1) {
            $itemsPerPage = User::count();
        } 
        $page = $params['itemsPerPage'] != -1 ? $params['page'] : 1;
        $search = $params['search'];

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        return DB::table('users')
        ->when($search != '', function($q) use ($search) {
            return $q->where('users.name', 'like', '%'. $search .'%');
        })
        ->paginate($itemsPerPage);
    }
}