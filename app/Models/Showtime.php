<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'room_id',
        'start_time',
        'end_time',
        'price',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
        'price'      => 'integer',
    ];

    /* =========================
     |        RELATIONS
     |=========================*/

    // Suất chiếu thuộc về phim
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    // Suất chiếu thuộc về phòng
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Suất chiếu có nhiều booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /* =========================
     |          HELPERS
     |=========================*/

    /**
     * Lấy toàn bộ ghế đã được đặt (để khóa ghế)
     * Chỉ tính booking hợp lệ
     *
     * @return array
     */
    public function getOccupiedSeatsAttribute()
    {
        return $this->bookings()
            ->whereIn('status', ['confirmed']) // ✅ FIX: bỏ 'paid' (DB không có)
            ->pluck('seats')
            ->flatMap(function ($seats) {
                return explode(',', $seats);
            })
            ->map(fn ($s) => trim($s))
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Kiểm tra 1 ghế đã bị đặt chưa
     */
    public function isSeatOccupied(string $seatCode): bool
    {
        return in_array($seatCode, $this->occupied_seats);
    }
}
