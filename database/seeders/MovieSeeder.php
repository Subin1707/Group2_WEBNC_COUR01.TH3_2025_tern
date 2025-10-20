<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        Movie::create([
            'title' => 'Avengers: Endgame',
            'description' => 'Superhero movie',
            'duration' => 181
        ]);

        Movie::create([
            'title' => 'Inception',
            'description' => 'Sci-fi thriller',
            'duration' => 148
        ]);
        
        Movie::factory()->count(50)->create();
    }
}
