<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép mass assignment
     */
    protected $fillable = [
        'user_id',
        'showtime_id',
        'booking_code',     // MÃ VÉ – DÙNG CHO QR
        'room_code',
        'seats',            // VD: "A1,A2,A3"
        'total_price',
        'payment_method',

        'status',           // pending | confirmed | cancelled
        'expires_at',

        // xác nhận thanh toán
        'confirmed_at',
        'confirmed_by',

        // 🔥 CHECK-IN VÀO RẠP (QR)
        'checked_in_at',
        'checked_in_by',
    ];

    /**
     * Ép kiểu dữ liệu
     */
    protected $casts = [
        'total_price'   => 'float',
        'expires_at'    => 'datetime',
        'confirmed_at'  => 'datetime',
        'checked_in_at' => 'datetime',
        'status'        => 'string',
    ];

    /* =========================
     |        BOOT
     |=========================*/

    /**
     * Tự sinh booking_code khi tạo vé
     */
    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = strtoupper(
                    'TICKET-' . Str::random(8)
                );
            }
        });
    }

    /* =========================
     |        RELATIONS
     |=========================*/

    // Booking thuộc về User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Booking thuộc về Showtime
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    /* =========================
     |        HELPERS
     |=========================*/

    /**
     * Trả về danh sách ghế dạng array
     */
    public function getSeatArrayAttribute(): array
    {
        return array_map('trim', explode(',', $this->seats));
    }

    /**
     * Vé đã được check-in chưa
     */
    public function isCheckedIn(): bool
    {
        return !is_null($this->checked_in_at);
    }

    /**
     * Staff check-in vé (scan QR)
     */
    public function checkIn(int $staffId): void
    {
        if ($this->status !== 'confirmed') {
            abort(403, '❌ Vé chưa được xác nhận');
        }

        if ($this->isCheckedIn()) {
            abort(409, '❌ Vé này đã được sử dụng');
        }

        $this->update([
            'checked_in_at' => now(),
            'checked_in_by' => $staffId,
        ]);
    }

    /* =========================
     |           SCOPES
     |=========================*/

    /**
     * Tìm booking theo mã vé (QR)
     */
    public function scopeByBookingCode($query, string $code)
    {
        return $query->where('booking_code', $code);
    }
}
