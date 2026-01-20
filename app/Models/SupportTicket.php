<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'subject',
        'category',
        'message',
        'status',
        'assigned_to',
    ];

    /* ================= RELATIONSHIPS ================= */

    // Người tạo ticket (khách hàng)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Booking liên quan (nếu có)
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Nhân viên / admin xử lý
    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Các phản hồi
    public function replies()
    {
        return $this->hasMany(SupportReply::class, 'ticket_id');
    }
}
