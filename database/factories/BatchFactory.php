<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Batch;
use App\Models\Medicine;

class BatchFactory extends Factory
{
    protected $model = Batch::class;

    public function definition()
    {
        $medicine = Medicine::factory()->create();
        
        return [
            'id' => $this->faker->uuid(),
            'medicine_id' => $medicine->id,
            'batch_number' => strtoupper($this->faker->unique()->bothify('BATCH-#####')),
            'quantity' => $this->faker->numberBetween(10, 100),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
        ];
    }
}
