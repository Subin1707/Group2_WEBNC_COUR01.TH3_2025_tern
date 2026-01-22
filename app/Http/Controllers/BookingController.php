<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /* ===================== ADMIN / STAFF LIST ===================== */
    public function index()
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $bookings = Booking::with(['showtime.movie', 'user'])
            ->latest()
            ->paginate(10);

        $view = Auth::user()->role === 'admin'
            ? 'bookings.admin.index'
            : 'bookings.staff.index';

        return view($view, compact('bookings'));
    }

    /* ===================== USER HISTORY ===================== */
    public function history()
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $bookings = Booking::where('user_id', Auth::id())
            ->with('showtime.movie')
            ->latest()
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    /* ===================== CHOOSE SHOWTIME ===================== */
    public function chooseShowtime(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $query = Showtime::with(['movie', 'room'])
            ->where('start_time', '>=', now());

        if ($request->filled('search')) {
            $query->whereHas('movie', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $showtimes = $query
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        return view('bookings.choose', compact('showtimes'));
    }

    /* ===================== CREATE (SEAT MAP) ===================== */
    public function create(Showtime $showtime)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);
        abort_if($showtime->start_time < now(), 403);

        $confirmedSeats = Booking::where('showtime_id', $showtime->id)
            ->where('status', 'confirmed')
            ->pluck('seats')
            ->flatMap(fn ($s) => explode(',', $s))
            ->map(fn ($s) => trim($s))
            ->toArray();

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
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
        ]);

$showtime = Showtime::with(['movie', 'room'])
    ->findOrFail($request->showtime_id);
        $seats = array_map('trim', explode(',', $request->seats));
        $totalPrice = count($seats) * $showtime->price;

        // ✅ VIEW ĐÚNG FILE: bookings/payment.blade.php
        return view('bookings.payment', compact(
            'showtime',
            'seats',
            'totalPrice'
        ));
    }

    /* ===================== STORE ===================== */
    public function store(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $request->validate([
            'showtime_id'    => 'required|exists:showtimes,id',
            'seats'          => 'required|string',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $showtime = Showtime::findOrFail($request->showtime_id);
        $selectedSeats = array_map('trim', explode(',', $request->seats));

        $lockedSeats = Booking::where('showtime_id', $showtime->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('seats')
            ->flatMap(fn ($s) => explode(',', $s))
            ->map(fn ($s) => trim($s))
            ->toArray();

        foreach ($selectedSeats as $seat) {
            abort_if(in_array($seat, $lockedSeats), 409, "Ghế {$seat} đã được giữ");
        }

        Booking::create([
            'user_id'        => Auth::id(),
            'showtime_id'    => $showtime->id,
            'seats'          => implode(',', $selectedSeats),
            'total_price'    => count($selectedSeats) * $showtime->price,
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

        abort_if($booking->user_id !== Auth::id(), 403);

        return view('bookings.show', compact('booking'));
    }
}
