<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    // 📋 Hiển thị danh sách suất chiếu
    public function index()
    {
        $showtimes = Showtime::with(['movie', 'room'])->latest()->get();
        return view('admin.showtimes.index', compact('showtimes'));
    }

    // ➕ Form tạo mới
    public function create()
    {
        $movies = Movie::all();
        $rooms = Room::all();
        return view('admin.showtimes.create', compact('movies', 'rooms'));
    }

    // 💾 Lưu suất chiếu mới
    public function store(Request $request)
    {
        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'price'      => 'required|numeric|min:0',
        ]);

        Showtime::create($request->all());

        return redirect()->route('showtimes.index')->with('success', '🎬 Thêm suất chiếu thành công!');
    }

    // 👁️ Hiển thị chi tiết
    public function show(Showtime $showtime)
    {
        return view('admin.showtimes.show', compact('showtime'));
    }

    // ✏️ Form sửa
    public function edit(Showtime $showtime)
    {
        $movies = Movie::all();
        $rooms = Room::all();
        return view('admin.showtimes.edit', compact('showtime', 'movies', 'rooms'));
    }

    // 🔄 Cập nhật
    public function update(Request $request, Showtime $showtime)
    {
        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'price'      => 'required|numeric|min:0',
        ]);

        $showtime->update($request->all());

        return redirect()->route('showtimes.index')->with('success', '✅ Cập nhật suất chiếu thành công!');
    }

    // 🗑️ Xóa
    public function destroy(Showtime $showtime)
    {
        $showtime->delete();
        return redirect()->route('showtimes.index')->with('success', '🗑️ Xóa suất chiếu thành công!');
    }
}
