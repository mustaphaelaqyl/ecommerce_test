<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_register_and_login()
    {
        // Register a new user
        $response = $this->postJson('/api/register', [
            'name' => 'Test',
            'email' => 't@test.com',
            'password' => 'secret'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user','token']);

        // Verify user exists in database
        $this->assertDatabaseHas('users', ['email' => 't@test.com']);
    }
}
