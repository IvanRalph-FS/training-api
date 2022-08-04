<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends \Tests\TestCase
{
    public function testAdminCanSeeUsersListWithPagination()
    {
        $user = User::factory()->admin()->create();

        User::factory(10)->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/users');

        $response->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
    }

    public function testAdminCanCreateUser()
    {
        $data = [
            'username' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 0
        ];

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/users', $data);

        $response->assertCreated();

        $response->assertJsonStructure([
            'data',
        ]);
    }

    public function testUserCannotCreateUser()
    {
        $data = [
            'username' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 0
        ];

        $user = User::factory()->user()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/users', $data);

        $response->assertUnauthorized();
    }

    public function testAdminCanUpdateUser()
    {
        $data = [
            'username' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => 0
        ];

        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/users/' . $user->id, $data);

        $this->assertEquals('1', $response->getOriginalContent());
    }

    public function testAdminCanDeleteUser()
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/users/' . $user->id);

        $this->assertSoftDeleted($user->refresh());
    }
}
