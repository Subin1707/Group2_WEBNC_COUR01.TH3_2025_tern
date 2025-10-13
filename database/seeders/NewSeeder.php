<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::Create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('news')->insert([
                'title' => $fake->sentence(6),
                'content' => $fake->paragraph(5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
