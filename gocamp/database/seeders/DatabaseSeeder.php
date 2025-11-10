<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin GoCamp',
            'email' => 'admin@gocamp.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Penyewa
        User::create([
            'name' => 'Penyewa Satu',
            'email' => 'penyewa@gocamp.com',
            'password' => Hash::make('penyewa123'),
            'role' => 'penyewa',
        ]);
    }
}
