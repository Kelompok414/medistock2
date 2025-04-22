<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::firstOrCreate( // ← ini penting!
            ['email' => 'admin@example.com'],
            [
                'name' => 'AdminExample',
                'password' => Hash::make('password'),
            ]
        );

        // Assign role setelah user dibuat
        $admin->assignRole('admin');
    }
}
