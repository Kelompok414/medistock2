<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\User;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::role('kasir')->inRandomOrder()->first()?->id ?? User::factory(),
            'supplier_name' => $this->faker->company(),
            'purchase_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
