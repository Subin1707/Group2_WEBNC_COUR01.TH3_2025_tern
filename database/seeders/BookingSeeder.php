<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Showtime;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $showtimes = Showtime::all();

        foreach ($users as $user) {
            // mỗi user đặt 2-3 vé ngẫu nhiên
            $sampleShowtimes = $showtimes->random(rand(2,3));

            foreach ($sampleShowtimes as $showtime) {
                Booking::create([
                    'user_id' => $user->id,
                    'showtime_id' => $showtime->id,
                    'seats' => implode(',', range(1, rand(1,5))), // số ghế ngẫu nhiên
                    'total_price' => $showtime->price * rand(1,5),
                    'status' => 'confirmed'
                ]);
            }
        }
    }
}
