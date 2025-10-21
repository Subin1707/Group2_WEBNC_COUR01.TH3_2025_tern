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
     */
   public function index(Request $request)
{
    $query = Showtime::with(['movie', 'room']);

    // 🔍 Nếu có từ khóa tìm kiếm
    if ($request->has('search') && !empty($request->search)) {
        $keyword = $request->search;

        $query->where(function ($q) use ($keyword) {
            $q->whereHas('movie', function ($m) use ($keyword) {
                $m->where('title', 'like', "%{$keyword}%");
            })
            ->orWhereHas('room', function ($r) use ($keyword) {
                $r->where('name', 'like', "%{$keyword}%");
            })
            ->orWhereDate('start_time', $keyword); // nếu nhập đúng ngày (yyyy-mm-dd)
        });
    }

    // 🕐 Sắp xếp và phân trang
    $showtimes = $query->orderBy('start_time', 'asc')->paginate(10);

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
     * 💾 Lưu suất chiếu mới
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date|after:now',
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
        $canBook = Auth::check() && Auth::user()->role === 'user';
        return view('showtimes.show', compact('showtime', 'canBook'));
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
     * 🔄 Cập nhật suất chiếu
     */
    public function update(Request $request, Showtime $showtime)
    {
        $this->authorizeAdmin();

        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date|after:now',
            'price'      => 'required|numeric|min:0',
        ]);

        $showtime->update($request->only(['movie_id', 'room_id', 'start_time', 'price']));

        return redirect()->route('admin.showtimes.index')
                         ->with('success', '✅ Cập nhật suất chiếu thành công!');
    }

    /**
     * 🗑️ Xóa suất chiếu
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
            abort(403, '⛔ Bạn không có quyền truy cập chức năng này.');
        }
    }
}
