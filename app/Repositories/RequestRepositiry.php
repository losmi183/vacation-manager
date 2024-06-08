<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\User;
use App\Models\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RequestRepositiry
{
  
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