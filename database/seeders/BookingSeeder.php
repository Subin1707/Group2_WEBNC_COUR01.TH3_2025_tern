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
            // Mỗi user đặt 2-3 vé ngẫu nhiên
            $sampleShowtimes = $showtimes->random(rand(2, 3));

            foreach ($sampleShowtimes as $showtime) {
                // Sinh ngẫu nhiên 1–5 ghế
                $seats = [];
                $rows = range('A', 'F'); // Hàng A đến F

                for ($i = 0; $i < rand(1, 5); $i++) {
                    $row = $rows[array_rand($rows)];
                    $number = rand(1, 10);
                    $seats[] = $row . $number;
                }

                Booking::create([
                    'user_id' => $user->id,
                    'showtime_id' => $showtime->id,
                    'seats' => implode(',', $seats),
                    'total_price' => $showtime->price * count($seats),
                    'status' => 'confirmed',
                ]);
            }
        }
    }
}
