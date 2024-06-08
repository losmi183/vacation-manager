<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;
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

        $this->requestService->request($data);

        return response()->json([
            'message' => 'Request created by user',
        ]);
    }
}
