<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin GoCamp',
            'email' => 'admin@gocamp.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Penyewa GoCamp',
            'email' => 'penyewa@gocamp.com',
            'password' => Hash::make('password'),
            'role' => 'penyewa'
        ]);
    }
}
