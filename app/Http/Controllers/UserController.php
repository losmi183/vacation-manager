<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UsersPaginateRequest;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function users(): JsonResponse
    {
        $result = $this->userService->users();

        return response()->json([
            'users' => $result
        ]);
    }

    public function usersPaginate(UsersPaginateRequest $request): JsonResponse
    {
        $params = $request->validated();

        $result = $this->userService->usersPaginate($params);

        return response()->json($result);
    }
}
