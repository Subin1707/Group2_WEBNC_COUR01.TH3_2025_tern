<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Lấy top 4 phim có nhiều vé đặt nhất
        $trendingMovieIds = DB::table('movies')
            ->join('showtimes', 'movies.id', '=', 'showtimes.movie_id')
            ->join('bookings', 'showtimes.id', '=', 'bookings.showtime_id')
            ->whereDate('bookings.created_at', '<=', $today)
            ->select('movies.id', DB::raw('SUM(LENGTH(bookings.seats) - LENGTH(REPLACE(bookings.seats, ",", "")) + 1) as total_tickets'))
            ->groupBy('movies.id')
            ->orderByDesc('total_tickets')
            ->limit(4)
            ->pluck('movies.id'); // chỉ lấy id phim

        // Lấy đầy đủ thông tin phim theo ID vừa thống kê
        $trendingMovies = Movie::whereIn('id', $trendingMovieIds)->get();

        return view('home', compact('trendingMovies'));
    }
}
