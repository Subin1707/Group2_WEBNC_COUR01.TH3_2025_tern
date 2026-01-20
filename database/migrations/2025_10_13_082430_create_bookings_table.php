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
                  ->onDelete('cascade');

            $table->foreignId('showtime_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('seats');

            $table->decimal('total_price', 8, 2);

            // ✅ THÊM CỘT PHƯƠNG THỨC THANH TOÁN
            $table->enum('payment_method', ['cash', 'transfer'])
                  ->nullable()
                  ->comment('cash = tiền mặt, transfer = chuyển khoản');

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
