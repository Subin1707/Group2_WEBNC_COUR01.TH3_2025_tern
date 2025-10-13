<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // ⚠️ Bắt buộc phải import model User

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin123@gmail.com',
            'password' => bcrypt('12345678'), // Mật khẩu mặc định
            'role' => 'admin', // Vai trò admin
        ]);
        User::create([
            'name' => 'Regular User',
            'email' => 'user123@gmail.com',
            'password' => bcrypt('123456'), // Mật khẩu mặc định
            'role' => 'user', // Vai trò người dùng
        ]);
    }
}
