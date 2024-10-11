<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreUserRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_fails_for_invalid_user_name()
    {
        // Simulate a POST request with an invalid userName (numbers)
        $response = $this->postJson('/api/users', [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'userName' => 'john123', // Invalid userName
            'countryCode' => 'US',
            'ipAddress' => '192.168.1.1',
        ]);

        // Assert that the response contains the correct validation error
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['user_name']);
    }

    public function test_successful_user_creation()
    {
        // Simulate a POST request with valid data
        $response = $this->postJson('/api/users', [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'userName' => 'johndoe', // Valid userName
            'countryCode' => 'US',
            'ipAddress' => '192.168.1.1',
        ]);

        // Assert the response is successful and the data is correct
        $response->assertStatus(201)
                 ->assertJson([
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'userName' => 'johndoe',
                    'countryName' => 'United States',
                 ]);
    }
}
