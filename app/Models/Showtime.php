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
     * Danh sách ghế đã bị khóa
     * Bao gồm: pending + confirmed
     */
    public function getOccupiedSeatsAttribute(): array
    {
        return $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('seats')
            ->flatMap(fn ($seats) => explode(',', $seats))
            ->map(fn ($s) => trim($s))
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Kiểm tra 1 ghế đã bị khóa hay chưa
     */
    public function isSeatOccupied(string $seatCode): bool
    {
        return in_array($seatCode, $this->occupied_seats, true);
    }
}
