<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_login_successfully()
    {
        $users = User::all()->toArray();
        $response = $this->postJson('api/user/login', [
            'email' => $users[0]['email'],
            'password' => substr($users[0]['email'], 0, strpos($users[0]['email'], '@')),
        ])->assertStatus(Response::HTTP_OK)->json();

        $this->assertNotEmpty($response['token']);
        $this->assertNotEmpty($response['user_profile']);
    }

    public function test_user_login_unsuccessfully_invalid_params()
    {
        $users = User::all()->toArray();
        $this->postJson('api/user/login', [
            'email' => $users[0]['email'],
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }

    public function test_user_login_unsuccessfully_invalid_password()
    {
        $users = User::all()->toArray();
        $this->postJson('api/user/login', [
            'email' => $users[0]['email'],
            'password' => 'invalid',
        ])->assertStatus(Response::HTTP_UNAUTHORIZED)->json();
    }

    public function test_user_logout_successfully()
    {
        // Login the user first
        $this->loginUser();
        
        // Now, logout
        $response = $this->postJson('api/user/logout', [])->assertStatus(Response::HTTP_OK)->json();        
    }
    
    public function test_user_logout_unsuccessfully()
    {
        // Try to logout when not authenticated

        $this->expectException(AuthenticationException::class);
        $this->postJson('api/user/logout', [])->json();        
    }
}
