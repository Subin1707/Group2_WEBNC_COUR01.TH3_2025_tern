<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 📋 Danh sách đặt vé (Admin)
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem danh sách đặt vé.');
        }

        $bookings = Booking::with(['showtime.movie', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    // 🕒 Trang chọn lịch chiếu trước khi đặt vé (Client)
    public function chooseShowtime()
    {
        $showtimes = Showtime::with(['movie', 'theater', 'room'])
            ->orderBy('start_time', 'asc')
            ->get();

        return view('bookings.choose', compact('showtimes'));
    }

    // ➕ Form đặt vé cho 1 suất chiếu cụ thể (Client)
    public function create(Showtime $showtime)
    {
        return view('bookings.create', compact('showtime'));
    }

    // 💾 Lưu vé mới (Client)
    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
            'total_price' => 'required|numeric|min:0',
        ]);

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

    // 🧾 Lịch sử đặt vé (Client)
    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('showtime.movie')
            ->latest()
            ->get();

        return view('bookings.history', compact('bookings'));
    }

    // 👁️ Chi tiết (Admin)
    public function show(Booking $booking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem chi tiết đặt vé.');
        }

        return view('admin.bookings.show', compact('booking'));
    }

    // ✏️ Sửa (Admin)
    public function edit(Booking $booking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa đặt vé.');
        }

        $showtimes = Showtime::with('movie')->get();
        return view('admin.bookings.edit', compact('booking', 'showtimes'));
    }

    // 🔄 Cập nhật (Admin)
    public function update(Request $request, Booking $booking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền cập nhật đặt vé.');
        }

        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($request->all());
        return redirect()->route('admin.bookings.index')
            ->with('success', '✅ Cập nhật đặt vé thành công!');
    }

    // 🗑️ Xóa (Admin)
    public function destroy(Booking $booking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa đặt vé.');
        }

        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', '🗑️ Xóa đặt vé thành công!');
    }
}
