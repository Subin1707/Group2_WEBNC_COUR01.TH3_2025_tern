<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            /* ================= USER & SHOWTIME ================= */
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('showtime_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /* ================= VÉ ================= */
            // Mã vé hiển thị cho khách
            $table->string('booking_code')->unique();

            // 🔥 TOKEN QR – dùng cho scan check-in
            $table->uuid('qr_token')->unique();

            // Mã / tên phòng (snapshot lúc đặt vé)
            $table->string('room_code')->nullable();

            /* ================= GHẾ & GIÁ ================= */
            // Ví dụ: A1,A2,A3
            $table->string('seats');

            // Tổng tiền (VNĐ)
            $table->unsignedInteger('total_price');

            /* ================= THANH TOÁN ================= */
            $table->enum('payment_method', ['cash', 'transfer'])
                  ->nullable()
                  ->comment('cash = tiền mặt, transfer = chuyển khoản');

            /* ================= TRẠNG THÁI ================= */
            $table->enum('status', [
                'pending',     // giữ ghế / chờ thanh toán
                'confirmed',   // staff xác nhận
                'cancelled'
            ])->default('pending');

            /* ================= CHECK-IN ================= */
            // Đã scan QR vào rạp (chống scan lại)
            $table->timestamp('checked_in_at')->nullable();

            /* ================= STAFF ================= */
            // Thời điểm staff xác nhận thanh toán
            $table->timestamp('confirmed_at')->nullable();

            $table->foreignId('confirmed_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            /* ================= INDEX ================= */
            $table->index(['showtime_id', 'status']);
            $table->index('qr_token');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
