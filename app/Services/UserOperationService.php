<?php

namespace App\Services;

use App\Models\Operation;
use App\Models\User;
use App\Models\UserOperation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserOperationService
{
    protected $operationService;
    protected $randomStringService;

    public function __construct(OperationService $operationService, RandomStringService $randomStringService)
    {
        $this->operationService = $operationService;
        $this->randomStringService = $randomStringService;
    }

    public function getAll(array $params): LengthAwarePaginator
    {
        // Define default pagination settings
        $page = !empty($params['page']) ? $params['page'] : 1;     
        $perPage = !empty($params['per_page']) ? $params['per_page'] : 50;     

        // Retrieve records based on filter criteria
        $query = UserOperation::where('user_id', Auth::user()->id);

        if (!empty($params['filter_column']) && !empty($params['filter_value'])) {
            $query->where($params['filter_column'], $params['filter_value']);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getById(int $id): UserOperation|null
    {
        return UserOperation::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->get();
    }
    
    public function deleteById(int $id): bool|null
    {
        $userOperation = UserOperation::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        if (!$userOperation) {
            return false;
        }

        return $userOperation->delete();
    }   

    public function postAdditionOperation(float|int $valueA, float|int $valueB): UserOperation|bool
    {
        $operation = $this->operationService->getById(Operation::OPERATION_ADDITION_ID);

        if (!$this->canAffordOperation($operation)) {
            return false;
        }

        $operationResponse = $valueA + $valueB;

        return $this->registerOperation(Auth::user(), $operation, $operationResponse);
    }

    public function postSubstractionOperation(float|int $valueA, float|int $valueB): UserOperation|bool
    {
        $operation = $this->operationService->getById(Operation::OPERATION_SUBSTRACTION_ID);
        if (!$this->canAffordOperation($operation)) {
            return false;
        }

        $operationResponse = $valueA - $valueB;

        return $this->registerOperation(Auth::user(), $operation, $operationResponse);
    }

    public function postMultiplicationOperation(float|int $valueA, float|int $valueB): UserOperation|bool
    {
        $operation = $this->operationService->getById(Operation::OPERATION_MULTIPLICATION_ID);
        if (!$this->canAffordOperation($operation)) {
            return false;
        }

        $operationResponse = $valueA * $valueB;

        return $this->registerOperation(Auth::user(), $operation, $operationResponse);
    }

    public function postDivisionOperation(float|int $valueA, float|int $valueB): UserOperation|bool
    {
        $operation = $this->operationService->getById(Operation::OPERATION_DIVISION_ID);
        if (!$this->canAffordOperation($operation)) {
            return false;
        }

        $operationResponse = $valueA / $valueB;

        return $this->registerOperation(Auth::user(), $operation, $operationResponse);
    }   

    public function postSquareRootOperation(float|int $valueA): UserOperation|bool
    {
        $operation = $this->operationService->getById(Operation::OPERATION_SQUARE_ROOT_ID);
        if (!$this->canAffordOperation($operation)) {
            return false;
        }

        $operationResponse = sqrt($valueA);

        return $this->registerOperation(Auth::user(), $operation, $operationResponse);
    }
    
    public function postRandomStringOperation(array $params): UserOperation|int
    {
        $operation = $this->operationService->getById(Operation::OPERATION_RANDOM_STRING_ID);
        if (!$this->canAffordOperation($operation)) {
            return 0;
        }

        $randomString = $this->randomStringService->getRandomString($params);
        if ($randomString === false) {
            return 1;
        }

        return $this->registerOperation(Auth::user(), $operation, $randomString);
    }   

    public function canAffordOperation(Operation $operation) {
        $user = User::find(Auth::user()->id);

        return $user->balance >= $operation->cost;
    }

    public function registerOperation(User $user, Operation $operation, float|int|string $operationResponse): UserOperation
    {
        // User balance will be automatically deducted by using app\Observers\UserOperationObserver.php
        return UserOperation::create([
            'user_id' => $user->id,            
            'operation_id' => $operation->id,
            'amount' => $operation->cost,
            'user_balance' => $user->balance - $operation->cost,
            'operation_response' => json_encode($operationResponse),
        ]);  
    }    
}