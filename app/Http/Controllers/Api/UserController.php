<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    const DEFAULT_ERROR_PREFIX = 'error';
    
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userService->register($request->get('email'), $request->get('password'));

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $this->userService->getUserToken($request->get('email'), $request->get('password'));
        if ($token === false) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['token' => $token], Response::HTTP_OK);
    }
    
    public function logout(Request $request) 
    {
        $this->userService->deleteUserToken($request->user());

        return response()->json(['logout'], Response::HTTP_OK);
    }
}
