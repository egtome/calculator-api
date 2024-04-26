<?php

use App\Http\Controllers\Api\OperationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserOperationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('user/logout', [UserController::class, 'logout']);   
    Route::get('operations', [OperationController::class, 'index']);         
    Route::get('user/operations', [UserOperationController::class, 'index']); 
    Route::post('user/operation/addition', [UserOperationController::class, 'postAdditionOperation']);       
    Route::post('user/operation/substraction', [UserOperationController::class, 'postSubstractionOperation']);       
    Route::post('user/operation/multiplication', [UserOperationController::class, 'postMultiplicationOperation']);       
    Route::post('user/operation/division', [UserOperationController::class, 'postDivisionOperation']);       
    Route::post('user/operation/square-root', [UserOperationController::class, 'postSquareRootOperation']);       
    Route::post('user/operation/random-string', [UserOperationController::class, 'postRandomStringOperation']);       
    Route::delete('user/operation/{id}', [UserOperationController::class, 'remove']);
});
