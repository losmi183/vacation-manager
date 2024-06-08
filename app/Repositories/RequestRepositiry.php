<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\User;
use App\Models\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RequestRepositiry
{

    public function requests(int $user_id): Collection
    {
        return Request::where('user_id', $user_id)->get();
    }

    /**
     * teamRequests - ony requests that have status Cekanje or Odobren
     * 
     * @param array $user_ids - teammates ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function teamRequests(array $user_ids): Collection
    {
        $status = config('settings.status');
        return Request::whereIn('user_id', $user_ids)
        ->whereIn('status', [$status['Cekanje'], $status['Odobren']])
        ->get();
    }

    /**
     * teamRequestsAll - all requests by team
     * 
     * @param array $user_ids
     * 
     * @return Collection
     */
    public function teamRequestsAll(array $user_ids): Collection
    {
        $status = config('settings.status');
        return Request::whereIn('user_id', $user_ids)
        ->get();
    }
  
    public function create(array $data): Request
    {
        try {
            $request = Request::create($data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, "Request not created");
        }
        return $request;
    }
   
}