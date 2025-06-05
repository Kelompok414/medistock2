<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Medicine;
use App\Models\Category;
use Illuminate\Support\Arr;

class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'category_id' => function () {
                $categoryIds = Category::pluck('id')->toArray();
                return Arr::random($categoryIds);
            },
            'name' => ucfirst($this->faker->word) . ' ' . $this->faker->randomElement(['Tablet', 'Syrup', 'Capsule']),
            'code' => strtoupper($this->faker->unique()->bothify('MED-####')),
            'dosage' => $this->faker->randomElement(['250mg', '500mg', '100mg']),
            'price' => $this->faker->numberBetween(5000, 300000)
        ];
    }
}
