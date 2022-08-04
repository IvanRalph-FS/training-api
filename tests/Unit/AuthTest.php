<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class AuthTest extends \Tests\TestCase
{
    public function testUserCanLogin()
    {
        $user = User::factory()->create();

        $data = [
            'username' => $user->username,
            'password' => 'password',
            'device_name' => 'unit_test'
        ];

        $response = $this->post('/api/sanctum/token', $data);

        $response->assertJsonStructure(['token']);
        $response->assertOk();

        $authCheckResponse = $this->withHeaders([
                'Authorization' => 'Bearer ' . $response->getOriginalContent()['token']
            ])->get('/api/auth/check');

        $authCheckResponse->assertJson([
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'full_name' => $user->full_name,
                'role' => $user->role
            ]
        ]);

        $authCheckResponse->assertOk();
    }

    public function testUserInvalidCredentials()
    {
        $data = [
            'username' => 'definitely_wrong_username',
            'password' => 'password',
            'device_name' => 'unit_test'
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/sanctum/token', $data);

        $response->assertJson([
            'message' => 'The provided credentials are incorrect',
            'errors' => [
                'username' => [
                    'The provided credentials are incorrect'
                ]
            ]
        ]);

        $response->assertStatus(422);
    }
}
