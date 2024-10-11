<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_fetches_all_transactions()
    {
        $user = User::factory()->create();
        Transaction::factory()->count(3)->for($user)->create();

        $response =$this->getJson("/api/v1/transactions");

        $response->assertStatus(200)
                ->assertJsonCount(3,'data');
    }

    #[Test]
    public function it_creates_a_new_transaction(): void
    {
        $user = User::factory()->create();

        $data = [
           'user_id' => $user->id,
           'amount' => 100.00,
           'status' => 'pending'
        ];

        $response = $this->postJson('/api/v1/transactions', $data);

        $response->assertStatus(201)
                 ->assertJson([
                    'data' => [
                        'amount' => 100.00,
                        'status' => 'pending',
                        'user' => [
                            'id' => $user->id
                        ]
                       
                    ]
                ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id, 
            'amount' => 100.00
        ]);
    }


    #[Test]
    public function it_shows_a_transaction()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->for($user)->create();

        $response = $this->getJson("/api/v1/transactions/{$transaction->id}");

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'id' => $transaction->id,
                        'amount' => $transaction->amount,
                    ]
                    ]);
    }


    #[Test]
    public function it_updates_a_transaction()
    {
        $user = User::factory()->create();
        $transaction= Transaction::factory()->for($user)->create();

        $data = [
            'amount' => 200.00,
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/v1/transactions/{$transaction->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'amount' => 200.00,
                        'status' => 'completed'
                    ]
                    ]);
        $this->assertDatabaseHas('transactions', ['id' => $transaction->id,'amount'=> 200.00]);
    }
}
