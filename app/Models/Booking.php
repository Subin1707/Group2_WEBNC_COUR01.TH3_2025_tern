<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép mass assignment
     */
    protected $fillable = [
        'user_id',
        'showtime_id',
        'seats',          // VD: "A1,A2,A3"
        'total_price',
        'payment_method',
        'status',         // pending | confirmed | cancelled
    ];

    /**
     * Ép kiểu dữ liệu
     */
    protected $casts = [
        'total_price' => 'integer',
        'status'      => 'string',
    ];

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

    // Booking có nhiều ticket hỗ trợ (CSKH)
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    /* =========================
     |     ACCESSORS / HELPERS
     |=========================*/

    /**
     * Trả về danh sách ghế dạng array
     * Ví dụ: ["A1", "A2", "A3"]
     */
    public function getSeatArrayAttribute(): array
    {
        if (!$this->seats) {
            return [];
        }

        return array_map('trim', explode(',', $this->seats));
    }

    /**
     * Kiểm tra booking này có giữ ghế hay không
     * (dùng cho logic khóa ghế)
     */
    public function isHoldingSeats(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true);
    }

    /* =========================
     |           SCOPES
     |=========================*/

    /**
     * Lấy booking theo suất chiếu
     */
    public function scopeByShowtime($query, $showtimeId)
    {
        return $query->where('showtime_id', $showtimeId);
    }
}
