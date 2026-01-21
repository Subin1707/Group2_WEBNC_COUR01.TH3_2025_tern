<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'theater_id',
        'name',
        'seat_rows',
        'seat_cols',
    ];

    // ✅ ÉP KIỂU – RẤT NÊN CÓ
    protected $casts = [
        'seat_rows' => 'integer',
        'seat_cols' => 'integer',
    ];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
