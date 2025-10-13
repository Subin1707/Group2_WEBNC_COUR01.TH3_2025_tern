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

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
