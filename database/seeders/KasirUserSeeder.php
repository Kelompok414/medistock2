<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class KasirUserSeeder extends Seeder
{
    public function run()
    {
        $kasirData = [
            ['name' => 'Kasir Satu', 'email' => 'kasir@example.com'],
            ['name' => 'Kasir Dua', 'email' => 'kasir2@example.com'],
            ['name' => 'Kasir Tiga', 'email' => 'kasir3@example.com'],
        ];

        foreach ($kasirData as $data) {
            $kasir = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                ]
            );

            $kasir->assignRole('kasir');

            // Tambahkan ini untuk pastikan settings dibuat
            $kasir->setting()->firstOrCreate([], [
                'language' => 'id',
                'text_size' => 'default',
                'font_family' => 'Default',
                'theme' => 'Default',
                'brightness' => 100,
                'dark_mode' => false,
            ]);
        }
    }
}

