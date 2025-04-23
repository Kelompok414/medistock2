<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_access_transaction_index_page()
    {
        $response = $this->get('/transactions');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_transaction_create_page()
    {
        $response = $this->get('/transactions/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_transaction_edit_page()
    {
        $transaction = Transaction::factory()->create(['user_id' => $this->user->id]);
        $response = $this->get("/transactions/{$transaction->id}/edit");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_post_new_transaction()
    {
        $response = $this->post('/transactions', [
            'user_id' => $this->user->id,
            'total_price' => 10000,
            'transaction_date' => now(),
        ]);

        $response->assertRedirect('/transactions');
    }

    /** @test */
    public function it_can_delete_transaction()
    {
        $transaction = Transaction::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete("/transactions/{$transaction->id}");

        $response->assertRedirect('/transactions');
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
}
