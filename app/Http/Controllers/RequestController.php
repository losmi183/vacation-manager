<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserAllRequests;
use App\Http\Requests\UserMakeRequest;

class RequestController extends Controller
{
    private RequestService $requestService;

    public function __construct(RequestService $requestService) {
        $this->requestService = $requestService;
    }

    public function request(UserMakeRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->requestService->request($data);

        return response()->json([
            'message' => 'Request created by user',
            'request' => $result
        ]);
    }
    public function userCancelRequest($id): JsonResponse
    {
        $result = $this->requestService->userCancelRequest($id);

        return response()->json([
            'message' => 'Request canceled',
            'request' => $result
        ]);
    }



    public function requests(): JsonResponse
    {
        $result = $this->requestService->requests();

        return response()->json([
            'data' => $result,
        ]);
    }
    public function teamRequests(): JsonResponse
    {
        $result = $this->requestService->teamRequests();

        return response()->json($result);
    }

    public function managerTeamRequests(): JsonResponse
    {
        $result = $this->requestService->managerTeamRequests();
        return response()->json($result);
    }

    public function managerResolveRequest($id): JsonResponse
    {
        $result = $this->requestService->managerResolveRequest($id);

        return response()->json([
            'message' => 'Request approved',
            'request' => $result
        ]);
    }
    public function managerDenyRequest($id): JsonResponse
    {
        $result = $this->requestService->managerDenyRequest($id);

        return response()->json([
            'message' => 'Request deny',
            'request' => $result
        ]);
    }
}
