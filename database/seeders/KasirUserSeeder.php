<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class KasirUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
                    'password' => Hash::make('password'), // default password
                ]
            );

            $kasir->assignRole('kasir');
        }
    }
}
