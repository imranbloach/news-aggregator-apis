<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_registers_a_user_successfully()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123', // Ensure password confirmation for validation
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'user_id',
                         'name',
                         'email',
                         'token',
                         'created_at',
                     ],
                 ]);

        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    #[Test]
    public function it_fails_to_register_with_invalid_data()
    {
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    #[Test]
    public function it_logs_in_a_user_successfully()
    {
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'email' => 'john@gmail.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'user_id',
                         'name',
                         'email',
                         'token',
                         'created_at',
                     ],
                 ]);
    }

    #[Test]
    public function it_fails_to_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'email' => 'john@gmail.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Invalid credentials',
                 ]);
    }
}
