<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /* ===================== LIST ===================== */

    public function index()
    {
        // ✅ ADMIN + STAFF xem toàn bộ
        if (in_array(Auth::user()->role, ['admin', 'staff'])) {
            $bookings = Booking::with(['showtime.movie', 'user'])
                ->latest()
                ->paginate(10);
        } 
        // ✅ CLIENT chỉ xem của mình
        else {
            $bookings = Booking::where('user_id', Auth::id())
                ->with('showtime.movie')
                ->latest()
                ->paginate(10);
        }

        return view('bookings.index', compact('bookings'));
    }

    /* ===================== CHOOSE SHOWTIME ===================== */

    public function chooseShowtime(Request $request)
    {
        $query = Showtime::with('movie', 'room')
            ->orderBy('start_time', 'desc');

        if ($request->filled('search')) {
            $query->whereHas('movie', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('start_time', $request->date);
        }

        $showtimes = $query->paginate(10)->appends($request->query());

        return view('bookings.choose', compact('showtimes'));
    }

    /* ===================== STEP 1: CREATE ===================== */

    public function create(Showtime $showtime)
    {
        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu đã qua!');
        }

        return view('bookings.create', compact('showtime'));
    }

    /* ===================== STEP 2: PREVIEW PAYMENT ===================== */

    public function previewPayment(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string|max:255',
        ]);

        $showtime = Showtime::with(['movie', 'room'])->findOrFail($request->showtime_id);

        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu đã qua!');
        }

        $selectedSeats = array_map('trim', explode(',', $request->seats));

        // 🔥 Check trùng ghế
        $exists = Booking::where('showtime_id', $showtime->id)
            ->where(function ($q) use ($selectedSeats) {
                foreach ($selectedSeats as $seat) {
                    $q->orWhere('seats', 'like', "%$seat%");
                }
            })
            ->exists();

        if ($exists) {
            return back()->with('error', '⚠️ Có ghế đã được đặt!');
        }

        $totalPrice = $showtime->price * count($selectedSeats);

        return view('bookings.payment', [
            'showtime'    => $showtime,
            'seats'       => implode(',', $selectedSeats),
            'total_price' => $totalPrice,
        ]);
    }

    /* ===================== STEP 3: STORE ===================== */

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id'    => 'required|exists:showtimes,id',
            'seats'          => 'required|string|max:255',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $showtime = Showtime::findOrFail($request->showtime_id);

        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu đã qua!');
        }

        $selectedSeats = array_map('trim', explode(',', $request->seats));

        $exists = Booking::where('showtime_id', $showtime->id)
            ->where(function ($q) use ($selectedSeats) {
                foreach ($selectedSeats as $seat) {
                    $q->orWhere('seats', 'like', "%$seat%");
                }
            })
            ->exists();

        if ($exists) {
            return back()->with('error', '⚠️ Ghế đã bị người khác đặt!');
        }

        Booking::create([
            'user_id'        => Auth::id(),
            'showtime_id'    => $showtime->id,
            'seats'          => implode(',', $selectedSeats),
            'total_price'    => $showtime->price * count($selectedSeats),
            'payment_method' => $request->payment_method,
            'status'         => 'pending',
        ]);

        return redirect()->route('bookings.history')
            ->with('success', '🎟️ Đặt vé thành công!');
    }

    /* ===================== CLIENT ===================== */

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
        // ✅ admin + staff xem mọi booking
        if (in_array(Auth::user()->role, ['admin', 'staff'])) {
            return view('bookings.show', compact('booking'));
        }

        // ✅ client chỉ xem của mình
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    /* ===================== ADMIN + STAFF ===================== */

    public function edit(Booking $booking)
    {
        $this->authorizeStaffOrAdmin();
        $showtimes = Showtime::with('movie')->get();

        return view('bookings.edit', compact('booking', 'showtimes'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorizeStaffOrAdmin();

        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string|max:255',
            'total_price' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($request->only([
            'showtime_id',
            'seats',
            'total_price',
            'status',
            'payment_method',
        ]));

        return redirect()->route('bookings.index')
            ->with('success', '✅ Cập nhật booking thành công!');
    }

    public function destroy(Booking $booking)
    {
        $this->authorizeStaffOrAdmin();
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', '🗑️ Xóa booking thành công!');
    }

    /* ===================== AUTH ===================== */

    private function authorizeStaffOrAdmin()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort(403);
        }
    }
}
