<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('showtime_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /**
             * Ghế đã đặt
             * Ví dụ: A1,A2,A3
             */
            $table->string('seats');

            /**
             * Tổng tiền (VNĐ)
             */
            $table->unsignedInteger('total_price');

            /**
             * Phương thức thanh toán
             */
            $table->enum('payment_method', ['cash', 'transfer'])
                  ->nullable()
                  ->comment('cash = tiền mặt, transfer = chuyển khoản');

            /**
             * Trạng thái booking
             */
            $table->enum('status', [
                'pending',     // chưa thanh toán
                'confirmed',   // đã thanh toán → KHÓA GHẾ
                'cancelled'
            ])->default('pending');

            /* =========================
             |        INDEX
             |=========================*/

            // Tối ưu query kiểm tra ghế
            $table->index(['showtime_id', 'status']);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
