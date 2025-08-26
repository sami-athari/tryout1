<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123123'),
            'role' => 'admin',
        ]);

        // Akun User
        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => Hash::make('123123'),
            'role' => 'user',
        ]);
    }
}
