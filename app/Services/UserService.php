<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie as HttpFoundationCookie;

class UserService
{
    public function register(string $email, string $password): User
    {
        return User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'active' => User::DEFAULT_ACTIVE_STATUS,
            'balance' => User::DEFAULT_BALANCE,
        ]);  
    }

    public function getUserToken(string $email, string $password, bool $generateCookie = true): string|bool
    {
        $user = $this->getAuthenticatedUserByEmailAndPassword($email, $password);

        if ($user === false) {
            return false;
        }

        return $user->createToken('token')->plainTextToken;
    } 

    public function getAuthenticatedUserByEmailAndPassword(string $email, string $password): User|bool
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return Auth::user();
        }

        return false;
    }
    
    public function getuserCookie(string $token): HttpFoundationCookie
    {
        return cookie('cookie_token', $token, 60 * 24);
    }     
}