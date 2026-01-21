<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            ->where('start_time', '>', now())
            ->orderBy('start_time');

        if ($request->filled('search')) {
            $query->whereHas('movie', fn ($q) =>
                $q->where('title', 'like', "%{$request->search}%")
            );
        }

        if ($request->filled('date')) {
            $query->whereDate('start_time', $request->date);
        }

        $showtimes = $query->paginate(10)->appends($request->query());

        return view('bookings.choose', compact('showtimes'));
    }

    /* ===================== CREATE (SEAT MAP) ===================== */

    public function create(Showtime $showtime)
    {
        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu đã qua!');
        }

        // 🔒 GHẾ ĐÃ THANH TOÁN (KHÓA VĨNH VIỄN)
        $confirmedSeats = Booking::where('showtime_id', $showtime->id)
            ->where('status', 'confirmed')
            ->pluck('seats')
            ->flatMap(fn ($s) => explode(',', $s))
            ->map(fn ($s) => trim($s))
            ->toArray();

        // 🔒 GHẾ PENDING CỦA USER KHÁC (timeout 10 phút)
        $pendingSeats = Booking::where('showtime_id', $showtime->id)
            ->where('status', 'pending')
            ->where('user_id', '!=', Auth::id())
            ->where('created_at', '>', now()->subMinutes(10))
            ->pluck('seats')
            ->flatMap(fn ($s) => explode(',', $s))
            ->map(fn ($s) => trim($s))
            ->toArray();

        $occupiedSeats = array_unique(array_merge($confirmedSeats, $pendingSeats));

        return view('bookings.create', compact('showtime', 'occupiedSeats'));
    }

    /* ===================== PAYMENT PREVIEW ===================== */

    public function paymentPreview(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
        ]);

        $showtime = Showtime::with(['movie', 'room'])->findOrFail($request->showtime_id);
        $seats = array_map('trim', explode(',', $request->seats));

        return view('bookings.payment', [
            'showtime' => $showtime,
            'seats'    => $seats,
            'quantity' => count($seats),
            'total'    => count($seats) * $showtime->price,
        ]);
    }

    /* ===================== STORE ===================== */

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id'    => 'required|exists:showtimes,id',
            'seats'          => 'required|string',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $showtime = Showtime::findOrFail($request->showtime_id);
        $selectedSeats = array_map('trim', explode(',', $request->seats));

        // 🔒 KIỂM TRA GHẾ ĐÃ CONFIRMED
        $confirmedSeats = Booking::where('showtime_id', $showtime->id)
            ->where('status', 'confirmed')
            ->pluck('seats')
            ->flatMap(fn ($s) => explode(',', $s))
            ->map(fn ($s) => trim($s))
            ->toArray();

        foreach ($selectedSeats as $seat) {
            if (in_array($seat, $confirmedSeats)) {
                return back()->with('error', "⚠️ Ghế {$seat} đã được thanh toán!");
            }
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
            ->with('success', '🎟️ Giữ ghế thành công! Vui lòng thanh toán trong 10 phút.');
    }

    /* ===================== SHOW ===================== */

    public function show(Booking $booking)
    {
        if (in_array(Auth::user()->role, ['admin', 'staff'])) {
            return view('bookings.show', compact('booking'));
        }

        abort_if($booking->user_id !== Auth::id(), 403);

        return view('bookings.show', compact('booking'));
    }

    /* ===================== HISTORY ===================== */

    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('showtime.movie')
            ->latest()
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    /* ===================== HELPERS ===================== */

    private function authorizeStaffOrAdmin()
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'staff']), 403);
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
