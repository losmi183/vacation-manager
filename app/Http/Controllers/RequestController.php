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
}
