<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Booking;

class DashboardController extends Controller
{
    // 📋 Hiển thị dashboard chung cho admin và client
    public function index()
    {
        $user = Auth::user(); // Lấy user hiện tại

        if (!$user) {
            abort(403, 'Bạn cần đăng nhập để truy cập trang này.');
        }

        // Nếu admin, lấy số liệu thống kê
        if ($user->role === 'admin') {
            $movies_count = Movie::count();
            $showtimes_count = Showtime::count();
            $bookings_count = Booking::count();

            return view('dashboard', compact(
                'user',
                'movies_count',
                'showtimes_count',
                'bookings_count'
            ));
        }

        // Nếu client, lấy số liệu cá nhân
        $user_bookings_count = Booking::where('user_id', $user->id)->count();
        $upcoming_showtimes_count = Showtime::where('start_time', '>', now())->count();

        return view('dashboard', compact(
            'user',
            'user_bookings_count',
            'upcoming_showtimes_count'
        ));
    }
}
