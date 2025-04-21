<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Saleitem;
use App\Models\Transaction;
use App\Models\Batch;

class SaleitemFactory extends Factory
{
    protected $model = Saleitem::class;

    public function definition()
    {
        $batch = Batch::factory()->create();
        $price = $this->faker->randomFloat(2, 5, 100);
        $qty = $this->faker->numberBetween(1, min(5, $batch->quantity));

        return [
            'id' => $this->faker->uuid(),
            'transaction_id' => Transaction::factory(),
            'batch_id' => $batch->id,
            'quantity' => $qty,
            'price_per_unit' => $price,
        ];
    }
}
