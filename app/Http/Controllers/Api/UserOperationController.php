<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserOperation;
use App\Services\UserOperationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class UserOperationController extends Controller
{
    const DEFAULT_ERROR_PREFIX = 'error';
    
    protected $userOperationService;

    public function __construct(UserOperationService $userService)
    {
        $this->userOperationService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        $requestParams = $request->all();
        $validator = Validator::make($requestParams, [
            'page' => 'nullable|numeric|gt:0',
            'per_page' => 'nullable|numeric|gt:0',
            'filter_column' => 'nullable|string',
            'filter_value' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!empty($requestParams['filter_column']) && !(Schema::hasColumn('user_operations', $requestParams['filter_column']))) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Invalid filter_column'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!empty($requestParams['filter_column']) && strtolower($requestParams['filter_column']) === 'user_id') {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }
        
        return response()->json(
            [
                'data' => $this->userOperationService->getAll($requestParams)
            ],
            Response::HTTP_OK
        );
    }

    public function postAdditionOperation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'value_a' => 'required|numeric',
            'value_b' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $userOperation = $this->userOperationService->postAdditionOperation($request->get('value_a'), $request->get('value_b'));
        if ($userOperation === false) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Not enough balance'], Response::HTTP_PAYMENT_REQUIRED);
        }

        return response()->json(['result' => $userOperation], Response::HTTP_CREATED);
    }

    public function postSubstractionOperation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'value_a' => 'required|numeric',
            'value_b' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $userOperation = $this->userOperationService->postSubstractionOperation($request->get('value_a'), $request->get('value_b'));
        if ($userOperation === false) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Not enough balance'], Response::HTTP_PAYMENT_REQUIRED);
        }

        return response()->json(['result' => $userOperation], Response::HTTP_CREATED);
    }
    
    public function postMultiplicationOperation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'value_a' => 'required|numeric',
            'value_b' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $userOperation = $this->userOperationService->postMultiplicationOperation($request->get('value_a'), $request->get('value_b'));
        if ($userOperation === false) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Not enough balance'], Response::HTTP_PAYMENT_REQUIRED);
        }

        return response()->json(['result' => $userOperation], Response::HTTP_CREATED);
    }
    
    public function postDivisionOperation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'value_a' => 'required|numeric',
            'value_b' => 'required|numeric|gt:0',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $userOperation = $this->userOperationService->postDivisionOperation($request->get('value_a'), $request->get('value_b'));
        if ($userOperation === false) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Not enough balance'], Response::HTTP_PAYMENT_REQUIRED);
        }

        return response()->json(['result' => $userOperation], Response::HTTP_CREATED);
    }
    
    public function postSquareRootOperation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'value_a' => 'required|numeric|gte:0',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $userOperation = $this->userOperationService->postSquareRootOperation($request->get('value_a'), $request->get('value_b'));
        if ($userOperation === false) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Not enough balance'], Response::HTTP_PAYMENT_REQUIRED);
        }

        return response()->json(['result' => $userOperation], Response::HTTP_CREATED);
    }
    
    public function postRandomStringOperation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'num' => 'required|numeric|gt:0',
            'len' => 'required|numeric|gt:0',
            'unique' => 'required|boolean',            
            'digits' => 'required|boolean',
            'upperalpha' => 'required|boolean',
            'loweralpha' => 'required|boolean',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $params = $request->all();
        if (!($params['digits'] || $params['upperalpha'] || $params['loweralpha'])) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'At least one of the digits or alphabet boxes must be ticked'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userOperation = $this->userOperationService->postRandomStringOperation($params);

        if (!($userOperation instanceof UserOperation)) {
            if ($userOperation == 0) {
                return response()->json([self::DEFAULT_ERROR_PREFIX => 'Not enough balance'], Response::HTTP_PAYMENT_REQUIRED);
            } else {
                return response()->json([self::DEFAULT_ERROR_PREFIX => 'Error requesting random strings'], Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }

        return response()->json(['result' => $userOperation], Response::HTTP_CREATED);
    }    

    public function remove(Request $request)
    {
        $userOperationId = $request->route('id');
        if (empty($userOperationId)) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Invalid ID'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $deleted = $this->userOperationService->deleteById((int)$userOperationId);

        if ($deleted === false) {
            // Invalid ID, or ID does not belong to user
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }

        return response()->json([''], Response::HTTP_NO_CONTENT);
    }
}
