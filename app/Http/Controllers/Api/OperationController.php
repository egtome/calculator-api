<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OperationService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OperationController extends Controller
{
    protected $operationService;

    public function __construct(OperationService $operationService)
    {
        $this->operationService = $operationService;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            [
                'data' => $this->operationService->getAll()
            ],
            Response::HTTP_OK
        );
    }
}
