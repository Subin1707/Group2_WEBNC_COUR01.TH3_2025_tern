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

        $bookings = Booking::with(['showtime.movie', 'user'])->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    // ➕ Form đặt vé (Khách hàng)
    public function create()
    {
        $showtimes = Showtime::with('movie')->get();
        return view('bookings.create', compact('showtimes')); // client booking form
    }

    // 💾 Lưu vé mới (Khách hàng)
    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
            'total_price' => 'required|numeric|min:0',
        ]);

        Booking::create([
            'user_id'     => Auth::id(), // user đang login
            'showtime_id' => $request->showtime_id,
            'seats'       => $request->seats,
            'total_price' => $request->total_price,
            'status'      => 'pending', // mặc định pending
        ]);

        return redirect()->route('client.bookings.index')->with('success', '🎟️ Đặt vé thành công!');
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
        return redirect()->route('bookings.index')->with('success', '✅ Cập nhật đặt vé thành công!');
    }

    // 🗑️ Xóa (Admin)
    public function destroy(Booking $booking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa đặt vé.');
        }

        $booking->delete();
        return redirect()->route('bookings.index')->with('success', '🗑️ Xóa đặt vé thành công!');
    }
}
