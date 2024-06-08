<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UserRoleRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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

    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->userService->store($data);

        return response()->json([
            'user' => $result,
            'message' => 'User created successfully'
        ]);
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $result = $this->userService->update($data, intval($id));

        return response()->json([
            'user' => $result,
            'message' => 'User created successfully'
        ]);
    }

    public function delete($id): JsonResponse
    {
        try {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(400, "Failed to delete user");
        }
    }

    public function userRole(UserRoleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->userRole($data);

        return response()->json([
            'message' => 'User role updated',
            'user' => $user
        ]);
    }
}
