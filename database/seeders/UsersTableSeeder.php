<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $usersData = [
            [
                'id' => 1,
                'email' => 'user1@test.com',
                'password' => Hash::make(env('USER_PASSWORD_FOR_TESTS')),
                'balance' => User::DEFAULT_BALANCE,
                'active' => User::DEFAULT_ACTIVE_STATUS,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'email' => 'user2@test.com',
                'password' => Hash::make(env('USER_PASSWORD_FOR_TESTS')),
                'balance' => 5000000,
                'active' => User::DEFAULT_ACTIVE_STATUS,
                'created_at' => now(),              
            ],
            [
                'id' => 3,
                'email' => 'user3@test.com',
                'password' => Hash::make(env('USER_PASSWORD_FOR_TESTS')),
                'balance' => 0,
                'active' => User::DEFAULT_ACTIVE_STATUS,
                'created_at' => now(),              
            ],                     
        ];

        User::insert($usersData);
    }
}
