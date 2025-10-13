<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ❌ Bỏ seeder lỗi về bảng "news"
        // $this->call(NewSeeder::class);

        // 👤 Tạo user mẫu
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 👑 Tạo admin mẫu (nếu có UserSeeder riêng)
        $this->call(UserSeeder::class);
    }
}
