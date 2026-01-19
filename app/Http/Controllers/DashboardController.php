<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\User;

class DashboardController extends Controller
{
    //  Hiển thị dashboard chung cho admin và client
public function index()
{
    $user = Auth::user();

    if (!$user) {
        abort(403, 'Bạn cần đăng nhập để truy cập trang này.');
    }

    // ================= ADMIN =================
    if ($user->role === 'admin') {
        $userCount = User::count();
        $movieCount = Movie::count();
        $ticketCount = Booking::count();
        $revenue = Booking::sum('total_price');

        return view('dashboard', compact(
            'user',
            'userCount',
            'movieCount',
            'ticketCount',
            'revenue'
        ));
    }

    // ================= STAFF =================
    if ($user->role === 'staff') {
        $todayBookings = Booking::whereDate('created_at', today())->count();
        $upcomingShowtimes = Showtime::where('start_time', '>', now())->count();
        $totalTickets = Booking::count();

        return view('dashboard', compact(
            'user',
            'todayBookings',
            'upcomingShowtimes',
            'totalTickets'
        ));
    }

    // ================= USER (CLIENT) =================
    $user_bookings_count = Booking::where('user_id', $user->id)->count();
    $upcoming_showtimes_count = Showtime::where('start_time', '>', now())->count();

    return view('dashboard', compact(
        'user',
        'user_bookings_count',
        'upcoming_showtimes_count'
    ));
}

    // Trang biểu đồ doanh thu
public function revenueChart()
{
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    $monthlyRevenueData = Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    $movieRevenueData = Booking::join('showtimes', 'bookings.showtime_id', '=', 'showtimes.id')
        ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
        ->selectRaw('movies.title, SUM(bookings.total_price) as total')
        ->groupBy('movies.title')
        ->pluck('total', 'movies.title');

    $monthlyRevenue = [
        'labels' => $monthlyRevenueData->keys()->map(fn($m) => "Tháng $m"),
        'data' => $monthlyRevenueData->values()
    ];

    $movieRevenue = [
        'labels' => $movieRevenueData->keys(),
        'data' => $movieRevenueData->values()
    ];

    return view('revenue', compact('monthlyRevenue', 'movieRevenue'));
}
}