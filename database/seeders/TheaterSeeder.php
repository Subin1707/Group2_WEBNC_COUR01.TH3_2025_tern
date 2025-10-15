<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater;

class TheaterSeeder extends Seeder
{
    public function run(): void
    {
        $theaters = [
            ['name' => 'Galaxy Cinema', 'address' => '123 Lê Lợi, HCM', 'total_rooms' => 5],
            ['name' => 'CGV Vincom', 'address' => '50 Nguyễn Huệ, HCM', 'total_rooms' => 6],
            ['name' => 'Lotte Cinema', 'address' => '200 Lê Duẩn, HCM', 'total_rooms' => 4],
        ];

        foreach ($theaters as $data) {
            Theater::create($data);
        }
    }
}
