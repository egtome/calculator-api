<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Tests\TestCase;

class OperationControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_operations_list_successfully()
    {
        // Login the user first
        $this->loginUser();

        $response = $this->getJson('api/operations', [])->assertStatus(Response::HTTP_OK)->json();

        $this->assertNotEmpty($response['data']);
    }
    
    public function test_operations_list_unauthenticated()
    {
        $this->expectException(AuthenticationException::class);
        $this->getJson('api/operations', [])->json();
    }
}
