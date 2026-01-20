<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        // ================= NEW CODE =================
        'role',
        // ============================================
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'staff' => 'Nhân viên',
            default => 'Khách hàng',
        };
    }
    // Ticket do user tạo
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    // Ticket user được phân xử lý (staff/admin)
    public function assignedTickets()
    {
        return $this->hasMany(SupportTicket::class, 'assigned_to');
    }

    // Phản hồi support
    public function supportReplies()
    {
        return $this->hasMany(SupportReply::class);
    }
}
