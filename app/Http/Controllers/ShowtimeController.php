<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowtimeController extends Controller
{
    /**
     * 📋 Hiển thị danh sách suất chiếu
     * - Admin: thấy tất cả
     * - Người dùng: chỉ xem danh sách (không lỗi redirect)
     */
    public function index()
    {
        $query = Showtime::with(['movie', 'room'])->latest();

        // Nếu là admin → hiển thị tất cả
        if (Auth::check() && Auth::user()->role === 'admin') {
            $showtimes = $query->paginate(10);
        } else {
            // Người dùng thường chỉ xem danh sách chung
            $showtimes = $query->paginate(10);
        }

        return view('showtimes.index', compact('showtimes'));
    }

    /**
     * ➕ Form tạo mới (chỉ admin)
     */
    public function create()
    {
        $this->authorizeAdmin();

        $movies = Movie::all();
        $rooms = Room::all();

        return view('showtimes.create', compact('movies', 'rooms'));
    }

    /**
     * 💾 Lưu suất chiếu mới (chỉ admin)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'price'      => 'required|numeric|min:0',
        ]);

        Showtime::create($request->only(['movie_id', 'room_id', 'start_time', 'price']));

        return redirect()->route('admin.showtimes.index')
                         ->with('success', '🎬 Thêm suất chiếu thành công!');
    }

    /**
     * 👁️ Hiển thị chi tiết suất chiếu
     */
    public function show(Showtime $showtime)
    {
        return view('showtimes.show', compact('showtime'));
    }

    /**
     * ✏️ Form chỉnh sửa (chỉ admin)
     */
    public function edit(Showtime $showtime)
    {
        $this->authorizeAdmin();

        $movies = Movie::all();
        $rooms = Room::all();

        return view('showtimes.edit', compact('showtime', 'movies', 'rooms'));
    }

    /**
     * 🔄 Cập nhật suất chiếu (chỉ admin)
     */
    public function update(Request $request, Showtime $showtime)
    {
        $this->authorizeAdmin();

        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'price'      => 'required|numeric|min:0',
        ]);

        $showtime->update($request->only(['movie_id', 'room_id', 'start_time', 'price']));

        return redirect()->route('admin.showtimes.index')
                         ->with('success', '✅ Cập nhật suất chiếu thành công!');
    }

    /**
     * 🗑️ Xóa suất chiếu (chỉ admin)
     */
    public function destroy(Showtime $showtime)
    {
        $this->authorizeAdmin();

        $showtime->delete();

        return redirect()->route('admin.showtimes.index')
                         ->with('success', '🗑️ Xóa suất chiếu thành công!');
    }

    /**
     * 🔒 Hàm phụ kiểm tra quyền admin
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
    }
}
