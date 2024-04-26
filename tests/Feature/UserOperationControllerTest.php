<?php

namespace Tests\Feature;

use App\Models\Operation;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserOperationControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_operation_addition_success()
    {
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->postJson('api/user/operation/addition', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_CREATED)->json();

        $this->assertNotEmpty($response['result']);

        //echo '<pre>';var_dump($response);die();
    }

    public function test_user_operation_addition_fail_bad_request()
    {
        // Login the user first
        $this->loginUser();

        $this->postJson('api/user/operation/addition', [
            'value_a' => 50,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }
    
    public function test_user_operation_addition_fail_not_enough_balance()
    {
        // Login the user first
        $this->loginUser();
        // Empty balance
        $this->emptyUserBalance();

        $this->postJson('api/user/operation/addition', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_PAYMENT_REQUIRED)->json();
    }

    public function test_user_operation_substraction_success()
    {
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->postJson('api/user/operation/substraction', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_CREATED)->json();

        $this->assertNotEmpty($response['result']);

        //echo '<pre>';var_dump($response);die();
    }

    public function test_user_operation_substraction_fail_bad_request()
    {
        // Login the user first
        $this->loginUser();

        $this->postJson('api/user/operation/substraction', [
            'value_a' => 50,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }
    
    public function test_user_operation_substraction_fail_not_enough_balance()
    {
        // Login the user first
        $this->loginUser();
        // Empty balance
        $this->emptyUserBalance();

        $this->postJson('api/user/operation/substraction', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_PAYMENT_REQUIRED)->json();
    }
    
    public function test_user_operation_multiplication_success()
    {
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->postJson('api/user/operation/multiplication', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_CREATED)->json();

        $this->assertNotEmpty($response['result']);

        //echo '<pre>';var_dump($response);die();
    }

    public function test_user_operation_multiplication_fail_bad_request()
    {
        // Login the user first
        $this->loginUser();

        $this->postJson('api/user/operation/multiplication', [
            'value_a' => 50,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }
    
    public function test_user_operation_multiplication_fail_not_enough_balance()
    {
        // Login the user first
        $this->loginUser();
        // Empty balance
        $this->emptyUserBalance();

        $this->postJson('api/user/operation/multiplication', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_PAYMENT_REQUIRED)->json();
    }
    
    public function test_user_operation_division_success()
    {
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->postJson('api/user/operation/division', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_CREATED)->json();

        $this->assertNotEmpty($response['result']);

        //echo '<pre>';var_dump($response);die();
    }

    public function test_user_operation_division_fail_bad_request()
    {
        // Login the user first
        $this->loginUser();

        $this->postJson('api/user/operation/division', [
            'value_a' => 50,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }

    public function test_user_operation_division_fail_division_by_zero()
    {
        // Login the user first
        $this->loginUser();

        $this->postJson('api/user/operation/division', [
            'value_a' => 50,
            'value_b' => 0,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }    
    
    public function test_user_operation_division_fail_not_enough_balance()
    {
        // Login the user first
        $this->loginUser();
        // Empty balance
        $this->emptyUserBalance();

        $this->postJson('api/user/operation/division', [
            'value_a' => 50,
            'value_b' => 100,
        ])->assertStatus(Response::HTTP_PAYMENT_REQUIRED)->json();
    }  
    
    public function test_user_operation_square_root_success()
    {
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->postJson('api/user/operation/square-root', [
            'value_a' => 25,
        ])->assertStatus(Response::HTTP_CREATED)->json();

        $this->assertNotEmpty($response['result']);

        //echo '<pre>';var_dump($response);die();
    }

    public function test_user_operation_square_root_fail_bad_request()
    {
        // Login the user first
        $this->loginUser();

        $this->postJson('api/user/operation/square-root', [
            'wrong_param' => 25,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }

    public function test_user_operation_square_root_fail_imaginary_number()
    {
        // Login the user first
        $this->loginUser();

        $this->postJson('api/user/operation/square-root', [
            'value_a' => -25,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }    
    
    public function test_user_operation_square_root_fail_not_enough_balance()
    {
        // Login the user first
        $this->loginUser();
        // Empty balance
        $this->emptyUserBalance();

        $this->postJson('api/user/operation/square-root', [
            'value_a' => 25,
        ])->assertStatus(Response::HTTP_PAYMENT_REQUIRED)->json();
    }    
}
