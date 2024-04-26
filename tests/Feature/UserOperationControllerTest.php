<?php

namespace Tests\Feature;

use App\Services\RandomStringService;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserOperationControllerTest extends TestCase
{
    protected $mockRandomStringServiceService;

    public function setUp(): void
    {
        parent::setUp();

        // Mock random string generator service
        $this->mockRandomStringServiceService = $this->mock(RandomStringService::class);
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
            'value_a' => -1,
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

    public function test_user_operation_random_string_success()
    {
        $params = [
            'num' => 10,
            'len' => 10,
            'digits' => false,
            'unique' => true,
            'upperalpha' => true,
            'loweralpha' => true,
        ];

        $this->mockRandomStringServiceService->shouldReceive('getRandomString')
                          ->once()
                          ->with($params)
                          ->andReturn('abcd1234');

        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->postJson('api/user/operation/random-string', $params)->assertStatus(Response::HTTP_CREATED)->json();

        $this->assertNotEmpty($response['result']);
    }
    
    public function test_user_operation_random_fail_invalid_params()
    {
        $params = [
            'num' => 10,
            'len' => 10,
        ];

        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $this->postJson('api/user/operation/random-string', $params)->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->json();
    }

    public function test_user_operation_random_string_fail_not_enough_balance()
    {
        // Login the user first
        $this->loginUser();
        // Empty balance
        $this->emptyUserBalance();

        $params = [
            'num' => 10,
            'len' => 10,
            'digits' => false,
            'unique' => true,
            'upperalpha' => true,
            'loweralpha' => true,
        ];

        $response = $this->postJson('api/user/operation/random-string', $params)->assertStatus(Response::HTTP_PAYMENT_REQUIRED)->json();
    }    

    public function test_user_operation_list_success()
    {
        $params = [
            'page' => 1,
            'per_page' => 50,
            'filter_column' => false,
            'filter_value' => false,
        ];
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->getJson('api/user/operations?' . http_build_query($params))->assertStatus(Response::HTTP_OK)->json();

        $this->assertNotEmpty($response['data']);
    }
    
    public function test_user_operation_list_with_filters_and_pagination_success()
    {
        $params = [
            'page' => 1,
            'per_page' => 50,
            'filter_column' => 'operation_id',
            'filter_value' => '1',
        ];
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $response = $this->getJson('api/user/operations?' . http_build_query($params))->assertStatus(Response::HTTP_OK)->json();

        $this->assertNotEmpty($response['data']);
    }
    
    public function test_user_operation_list_with_filters_fail_forbidden_filter_by_user_id()
    {
        $params = [
            'page' => 1,
            'per_page' => 50,
            'filter_column' => 'user_id',
            'filter_value' => '2',
        ];
        // Login the user first
        $this->restoreUserBalance();        
        $this->loginUser();

        $this->getJson('api/user/operations?' . http_build_query($params))->assertStatus(Response::HTTP_FORBIDDEN)->json();
    }

    public function test_should_delete_user_operation_belongs_to_user_correctly()
    {
        $this->loginUser();
        $this->deleteJson('api/user/operation/1')->assertStatus(Response::HTTP_NO_CONTENT);
        $this->restoreUserOperation(1);
    }

    public function test_should_not_delete_user_operation_does_not_belong_to_user_forbidden()
    {
        $this->loginUser();
        $this->deleteJson('api/user/operation/4')->assertStatus(Response::HTTP_FORBIDDEN);
        //$this->restoreUserOperation(4);
    }

    public function test_should_not_delete_user_operation_invalid_id()
    {
        $this->loginUser();

        $this->deleteJson('api/user/operation/9999999999')->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
