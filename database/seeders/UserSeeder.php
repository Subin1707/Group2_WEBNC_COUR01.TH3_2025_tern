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
            'name' => 'Admin User',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Client User',
            'email' => 'client123@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);

        // 👉 STAFF
        User::create([
            'name' => 'Staff User',
            'email' => 'staff123@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
        ]);

        User::factory()->count(20)->create();
    }
}
