<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_logs_in_a_user_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'johnsmith45@gmail.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->postJson('/api/v1/login',[
            "email" => 'johnsmith45@gmail.com',
            "password" => "password123"
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'token',
                    'profile'=> [
                         'id', 
                         'name',
                         'email'
                    ],
                    'message'
                    
                ]);
    }

    #[Test]
    public function it_fails_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password')
        ]);

        //invalid credentials
        $data = [
            'email' => 'user@example.com',
            'password' => 'wrongpassword'
        ];

        $response = $this->postJson('/api/v1/login', $data);

        //Assert status and error message
        $response->assertStatus(404)
                 ->assertJson([
                    'email' => ['The provided credentials are incorrect.']
                 ]);
    }

    #[Test] 
    public function it_fails_login_for_non_existing_user()
    {
        //Non-existing user credentials
        $data = [
            'email' => 'nonexisting@example.com',
            'password' => 'password'
        ];

        $response = $this->postJson('/api/v1/login', $data);

    $response->assertStatus(404)
            ->assertJson([
                'email' => ['The provided credentials are incorrect.']
            ]);
    }

   
}
