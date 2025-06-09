<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Medicine;
use App\Models\Batch;

class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition()
    {
        $medicine = Medicine::inRandomOrder()->first() ?? Medicine::factory()->create();

        $quantity = $this->faker->numberBetween(1, 100);
        $price = $this->faker->numberBetween(5000, 300000);

        return [
            'id' => $this->faker->uuid(),
            'purchase_id' => Purchase::factory(),
            'medicine_id' => $medicine->id,
            'quantity' => $quantity,
            'price_per_unit' => $price,
        ];
    }
}
