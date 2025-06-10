<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $categories = [
            'Analgesik',
            'Antibiotik',
            'Antiseptik',
            'Antipiretik',
            'Antihistamin',
            'Dekongestan',
            'Obat Batuk',
            'Obat Lambung',
            'Vitamin & Suplemen',
            'Obat Topikal',
            'Obat Mata',
            'Obat Herbal'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
