<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Admin: xem tất cả booking
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $bookings = Booking::with(['showtime.movie', 'user'])
                               ->latest()
                               ->paginate(10);
        } else {
            $bookings = Booking::where('user_id', Auth::id())
                               ->with('showtime.movie')
                               ->latest()
                               ->paginate(10);
        }

        return view('bookings.index', compact('bookings'));
    }

    // Client: danh sách suất chiếu để đặt vé
    public function chooseShowtime()
    {
        $showtimes = Showtime::with('movie', 'room')
                             ->orderBy('start_time', 'asc')
                             ->paginate(10);

        return view('bookings.choose', compact('showtimes'));
    }

    // Client: form đặt vé cho suất chiếu cụ thể
    public function create(Showtime $showtime)
    {
        return view('bookings.create', compact('showtime'));
    }

    // Client: lưu vé
    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string|max:5', // chỉ 1 ghế, ví dụ A1
        ]);

        // 🕒 Lấy suất chiếu
        $showtime = Showtime::findOrFail($request->showtime_id);

        // 🔍 1️⃣ Kiểm tra ngày chiếu có ở tương lai không
        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu này đã qua, bạn không thể đặt vé nữa!');
        }

        // 🔍 Kiểm tra ghế đã được đặt chưa
        $exists = Booking::where('showtime_id', $request->showtime_id)
                        ->where('seats', $request->seats)
                        ->exists();

        if ($exists) {
            return back()->with('error', '⚠️ Ghế này đã được đặt rồi, vui lòng chọn ghế khác!');
        }
        Booking::create([
            'user_id'     => Auth::id(),
            'showtime_id' => $request->showtime_id,
            'seats'       => $request->seats,
            'total_price' => $request->total_price,
            'status'      => 'pending',
        ]);

        return redirect()->route('bookings.history')
                         ->with('success', '🎟️ Đặt vé thành công!');
    }

    // Client: lịch sử đặt vé
    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
                           ->with('showtime.movie')
                           ->latest()
                           ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    // Chi tiết booking (Admin xem tất, Client xem của chính họ)
    public function show(Booking $booking)
    {
        if (Auth::user()->role === 'client' && $booking->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem chi tiết này.');
        }

        return view('bookings.show', compact('booking'));
    }

    // Admin: sửa booking
    public function edit(Booking $booking)
    {
        $this->authorizeAdmin();
        $showtimes = Showtime::with('movie')->get();

        return view('bookings.edit', compact('booking', 'showtimes'));
    }

    // Admin: cập nhật booking
    public function update(Request $request, Booking $booking)
    {
        $this->authorizeAdmin();

        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($request->all());

        return redirect()->route('bookings.index')
                         ->with('success', '✅ Cập nhật booking thành công!');
    }

    // Admin: xóa booking
    public function destroy(Booking $booking)
    {
        $this->authorizeAdmin();
        $booking->delete();

        return redirect()->route('bookings.index')
                         ->with('success', '🗑️ Xóa booking thành công!');
    }

    // Phương thức kiểm tra admin
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, '⛔ Bạn không có quyền truy cập.');
        }
    }
}
