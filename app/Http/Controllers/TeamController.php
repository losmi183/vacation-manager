<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TeamStoreRequest;

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
}
