<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 📋 Danh sách đặt vé
    public function index()
    {
        $bookings = Booking::with(['showtime.movie', 'user'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    // ➕ Form đặt vé
    public function create()
    {
        $showtimes = Showtime::with('movie')->get();
        return view('admin.bookings.create', compact('showtimes'));
    }

    // 💾 Lưu vé mới
    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,confirmed,cancelled',
        ]);

        Booking::create([
            'user_id'     => Auth::id() ?? 1, // tạm để 1 nếu chưa login
            'showtime_id' => $request->showtime_id,
            'seats'       => $request->seats,
            'total_price' => $request->total_price,
            'status'      => $request->status,
        ]);

        return redirect()->route('bookings.index')->with('success', '🎟️ Đặt vé thành công!');
    }

    // 👁️ Chi tiết
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    // ✏️ Sửa
    public function edit(Booking $booking)
    {
        $showtimes = Showtime::with('movie')->get();
        return view('admin.bookings.edit', compact('booking', 'showtimes'));
    }

    // 🔄 Cập nhật
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($request->all());
        return redirect()->route('bookings.index')->with('success', '✅ Cập nhật đặt vé thành công!');
    }

    // 🗑️ Xóa
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', '🗑️ Xóa đặt vé thành công!');
    }
}
