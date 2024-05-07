<?php

namespace Database\Seeders;

use App\Models\UserOperation;
use Illuminate\Database\Seeder;

class UserOperationsTableSeeder extends Seeder
{

    public function run()
    {
        $userOperationsData = [
            [
                'id' => 1,
                'user_id' => 1,
                'operation_id' => 1,
                'amount' => 100,
                'user_balance' => 1000,
                'operation_response' => '50',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'operation_id' => 1,
                'amount' => 100,
                'user_balance' => 1000,
                'operation_response' => '50',
                'created_at' => now(),              
            ],           
            [
                'id' => 3,
                'user_id' => 1,
                'operation_id' => 2,
                'amount' => 150,
                'user_balance' => 1000,
                'operation_response' => '50',
                'created_at' => now(),              
            ],           
            [
                'id' => 4,
                'user_id' => 2,
                'operation_id' => 1,
                'amount' => 100,
                'user_balance' => 1000,
                'operation_response' => '50',
                'created_at' => now(),              
            ],                   
        ];

        UserOperation::insert($userOperationsData);
    }
}
