<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
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

    public function chooseShowtime(Request $request)
    {
        $query = Showtime::with('movie', 'room')->orderBy('start_time', 'desc');

        $keyword = $request->input('search');   
        $date = $request->input('date');        

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('movie', function ($sub) use ($keyword) {
                    $sub->where('title', 'like', '%' . $keyword . '%');
                })->orWhereHas('room', function ($sub) use ($keyword) {
                    $sub->where('name', 'like', '%' . $keyword . '%');
                });
            });
        }

        if (!empty($date)) {
            $query->whereDate('start_time', $date);
        }

        $showtimes = $query->paginate(10)->appends($request->query());

        return view('bookings.choose', compact('showtimes'));
    }


    public function create(Showtime $showtime)
    {
        return view('bookings.create', compact('showtime'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string|max:5', 
        ]);

        $showtime = Showtime::findOrFail($request->showtime_id);

        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu này đã qua, bạn không thể đặt vé nữa!');
        }

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

    public function show(Booking $booking)
    {
        if (Auth::user()->role === 'client' && $booking->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem chi tiết này.');
        }

        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $this->authorizeAdmin();
        $showtimes = Showtime::with('movie')->get();

        return view('bookings.edit', compact('booking', 'showtimes'));
    }

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

    public function destroy(Booking $booking)
    {
        $this->authorizeAdmin();
        $booking->delete();

        return redirect()->route('bookings.index')
                         ->with('success', '🗑️ Xóa booking thành công!');
    }

    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, '⛔ Bạn không có quyền truy cập.');
        }
    }
}
