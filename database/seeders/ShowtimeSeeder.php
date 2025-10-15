<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::all();
        $rooms = Room::all();

        foreach ($movies as $movie) {
            foreach ($rooms as $room) {
                Showtime::create([
                    'movie_id' => $movie->id,
                    'room_id' => $room->id,
                    'start_time' => Carbon::now()->addDays(rand(1,5))->setHour(rand(10,20))->setMinute(0),
                    'price' => rand(50000, 150000)
                ]);
            }
        }
    }
}
