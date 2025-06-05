<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class KasirUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::firstOrCreate( // ← ini penting!
            ['email' => 'kasir@example.com'],
            [
                'name' => 'KasirExample',
                'password' => Hash::make('password'),
            ]
        );

        // Assign role setelah user dibuat
        $admin->assignRole('kasir');
    }
}
