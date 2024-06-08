<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamManagerRequest;
use App\Http\Requests\TeamAssignUserRequest;

class TeamController extends Controller
{
    private TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function store(TeamStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $team = $this->teamService->store($data);

        return response()->json([
            'message' => 'Team created',
            'team' => $team
        ]);
    }

    public function assignUser(TeamAssignUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->teamService->assignUser($data);

        return response()->json([
            'message' => 'User assigned to team',
            'user' => $user
        ]);
    }
    public function teamManager(TeamManagerRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->teamService->teamManager($data);

        return response()->json([
            'message' => 'User assigned to team',
            'user' => $user
        ]);
    }
}
