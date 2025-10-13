<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowtimeController extends Controller
{
    // 📋 Hiển thị danh sách suất chiếu (Admin)
    public function index()
    {
        // Chỉ admin mới xem được danh sách quản trị
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $showtimes = Showtime::with(['movie', 'room'])->latest()->paginate(10);
        return view('showtimes.index', compact('showtimes'));
    }

    // ➕ Form tạo mới (Admin)
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $movies = Movie::all();
        $rooms = Room::all();
        return view('showtimes.create', compact('movies', 'rooms'));
    }

    // 💾 Lưu suất chiếu mới (Admin)
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'price'      => 'required|numeric|min:0',
        ]);

        Showtime::create($request->all());

        return redirect()->route('showtimes.index')->with('success', '🎬 Thêm suất chiếu thành công!');
    }

    // 👁️ Hiển thị chi tiết (Admin)
    public function show(Showtime $showtime)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        return view('showtimes.show', compact('showtime'));
    }

    // ✏️ Form sửa (Admin)
    public function edit(Showtime $showtime)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $movies = Movie::all();
        $rooms = Room::all();
        return view('showtimes.edit', compact('showtime', 'movies', 'rooms'));
    }

    // 🔄 Cập nhật (Admin)
    public function update(Request $request, Showtime $showtime)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'price'      => 'required|numeric|min:0',
        ]);

        $showtime->update($request->all());

        return redirect()->route('showtimes.index')->with('success', '✅ Cập nhật suất chiếu thành công!');
    }

    // 🗑️ Xóa (Admin)
    public function destroy(Showtime $showtime)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $showtime->delete();
        return redirect()->route('showtimes.index')->with('success', '🗑️ Xóa suất chiếu thành công!');
    }
}
