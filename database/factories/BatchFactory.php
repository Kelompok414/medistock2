<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Batch;
use App\Models\Medicine;
use Illuminate\Support\Arr;

class BatchFactory extends Factory
{
    protected $model = Batch::class;

    public function definition()
    {
        $medicineIds = Medicine::pluck('id')->toArray();

        return [
            'id' => $this->faker->uuid(),
            'medicine_id' => function () use ($medicineIds) {
                return Arr::random($medicineIds);
            },
            'batch_number' => $this->faker->unique()->bothify('BATCH-####'),
            'quantity' => $this->faker->numberBetween(10, 100),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+2 years'),
        ];
    }
}
