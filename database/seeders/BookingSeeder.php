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

        if ($users->isEmpty() || $showtimes->isEmpty()) {
            $this->command->warn('⚠️ Không có user hoặc showtime.');
            return;
        }

        foreach ($users as $user) {

            $sampleShowtimes = $showtimes->random(rand(1, 3));

            foreach ($sampleShowtimes as $showtime) {

                // ✅ Tạo danh sách ghế không trùng
                $rows = range('A', 'F');
                $seatPool = [];

                foreach ($rows as $row) {
                    for ($i = 1; $i <= 10; $i++) {
                        $seatPool[] = $row . $i;
                    }
                }

                shuffle($seatPool);

                $seatCount = rand(1, 5);
                $seats = array_slice($seatPool, 0, $seatCount);

                Booking::create([
                    'user_id' => $user->id,
                    'showtime_id' => $showtime->id,
                    'seats' => implode(',', $seats),
                    'total_price' => $showtime->price * $seatCount,
                    'payment_method' => collect(['cash', 'transfer'])->random(),
                    'status' => collect(['pending', 'confirmed'])->random(),
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('✅ BookingSeeder nâng cao chạy thành công!');
    }
}
