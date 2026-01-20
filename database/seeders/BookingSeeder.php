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
        // Lấy danh sách user có role là 'user' (hoặc 'client' nếu bạn đặt như vậy)
        $users = User::where('role', 'user')->get();
        $showtimes = Showtime::all();

        // Kiểm tra có dữ liệu không
        if ($users->isEmpty() || $showtimes->isEmpty()) {
            $this->command->warn('⚠️ Không có user hoặc showtime để tạo booking.');
            return;
        }

        foreach ($users as $user) {
            // Mỗi user đặt 2–3 vé ngẫu nhiên
            $sampleShowtimes = $showtimes->random(rand(2, 3));

            foreach ($sampleShowtimes as $showtime) {
                // Sinh ngẫu nhiên 1–5 ghế
                $seats = [];
                $rows = range('A', 'F'); // Hàng A → F

                for ($i = 0; $i < rand(1, 5); $i++) {
                    $row = $rows[array_rand($rows)];
                    $number = rand(1, 10);
                    $seats[] = $row . $number;
                }

                Booking::create([
                    'user_id' => $user->id,
                    'showtime_id' => $showtime->id,
                    'seats' => implode(',', $seats), // Đảm bảo đúng tên cột
                    'total_price' => $showtime->price * count($seats),
                    'payment_method' => collect(['cash', 'transfer'])->random(),
                    'status' => 'confirmed',
                    'created_at' => now()->subDays(rand(0, 60)), // thêm chút ngẫu nhiên
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('✅ BookingSeeder đã tạo dữ liệu mẫu thành công!');
    }
}
