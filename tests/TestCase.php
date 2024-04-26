<?php

namespace Tests;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    protected function loginUser(): array
    {
        $users = User::all()->toArray();
        $response = $this->postJson('api/user/login', [
            'email' => $users[0]['email'],
            'password' => substr($users[0]['email'], 0, strpos($users[0]['email'], '@')),
        ])->assertStatus(Response::HTTP_OK)->json();
        $this->assertNotEmpty($response['token']);
        $this->assertNotEmpty($response['user_profile']);

        return $response;
    }

    protected function emptyUserBalance(): User
    {
        $user = User::find(1);
        $user->balance = 0;
        $user->save();

        return $user;
    }
    
    protected function restoreUserBalance(): User
    {
        $user = User::find(1);
        $user->balance = User::DEFAULT_BALANCE;
        $user->save();

        return $user;
    }    
}
