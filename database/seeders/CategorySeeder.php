<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
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

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
