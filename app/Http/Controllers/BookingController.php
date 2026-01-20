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
        if (in_array(Auth::user()->role, ['admin', 'staff'])) {
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

    /* ===================== CREATE ===================== */

    public function create(Showtime $showtime)
    {
        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu đã qua!');
        }

        return view('bookings.create', compact('showtime'));
    }

    /* ===================== PREVIEW ===================== */

    public function previewPayment(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string|max:255',
        ]);

        $showtime = Showtime::with(['movie', 'room'])->findOrFail($request->showtime_id);

        $selectedSeats = array_map('trim', explode(',', $request->seats));

        $exists = Booking::where('showtime_id', $showtime->id)
            ->where(function ($q) use ($selectedSeats) {
                foreach ($selectedSeats as $seat) {
                    $q->orWhere('seats', 'like', "%$seat%");
                }
            })->exists();

        if ($exists) {
            return back()->with('error', '⚠️ Ghế đã được đặt!');
        }

        return view('bookings.payment', [
            'showtime'    => $showtime,
            'seats'       => implode(',', $selectedSeats),
            'total_price' => $showtime->price * count($selectedSeats),
        ]);
    }

    /* ===================== STORE ===================== */

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id'    => 'required|exists:showtimes,id',
            'seats'          => 'required|string|max:255',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $showtime = Showtime::findOrFail($request->showtime_id);
        $selectedSeats = array_map('trim', explode(',', $request->seats));

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

    /* ===================== SHOW ===================== */

    public function show(Booking $booking)
    {
        if (in_array(Auth::user()->role, ['admin', 'staff'])) {
            return view('bookings.show', compact('booking'));
        }

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    /* ===================== EDIT ===================== */

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
            'seats'       => 'required|string',
            'total_price' => 'required|numeric',
            'status'      => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($request->only([
            'showtime_id',
            'seats',
            'total_price',
            'status',
            'payment_method',
        ]));

        return $this->redirectByRole('✅ Cập nhật booking thành công!');
    }

    public function destroy(Booking $booking)
    {
        $this->authorizeStaffOrAdmin();
        $booking->delete();

        return $this->redirectByRole('🗑️ Xóa booking thành công!');
    }

    /* ===================== HELPERS ===================== */

    private function authorizeStaffOrAdmin()
    {
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort(403);
        }
    }

    private function redirectByRole($message)
    {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.bookings.index')->with('success', $message),
            'staff' => redirect()->route('staff.bookings.index')->with('success', $message),
            default => redirect()->route('bookings.history')->with('success', $message),
        };
    }
}
