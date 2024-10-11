<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_fetches_all_users()
    {
        User::factory()->count(3)->create();
        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200)
                 ->assertJsoncount(3, 'data');
    }

    #[Test]
    public function it_creates_a_new_user(): void
    {
        $response = $this->postJson('/api/v1/users',[
            'name' => 'John Smith',
            "email" => 'johnsmith45@gmail.com',
            "password" => "password123"
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['id', 'name','email']]);
    }


    #[Test]
    public function it_shows_a_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'id' => $user->id,
                        'name' => $user->name,
                    ]
                 ]);
    }


    #[Test]
    public function it_updates_a_user()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'test Name',
            'email' => 'testemail@mail.com',
            'password'=> 'testpassword'
        ];

        $response = $this->putJson("/api/v1/users/{$user->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'name' => 'test Name',
                        'email' => 'testemail@mail.com'
                    ]
                 ]);
        $this->assertDatabaseHas('users',['email'=>'testemail@mail.com']);
    }


    #[Test]
    public function it_deletes_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/v1/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users',['id' => $user->id]);
    }
}
