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

    /* ===================== CHOOSE SHOWTIME ===================== */

    public function chooseShowtime(Request $request)
    {
        $query = Showtime::with('movie', 'room')->orderBy('start_time', 'desc');

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
            'seats'       => 'required|string|max:5',
        ]);

        $showtime = Showtime::with(['movie', 'room'])->findOrFail($request->showtime_id);

        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu đã qua!');
        }

        // Check ghế
        $exists = Booking::where('showtime_id', $showtime->id)
            ->where('seats', $request->seats)
            ->exists();

        if ($exists) {
            return back()->with('error', '⚠️ Ghế này đã được đặt!');
        }

        $totalPrice = $showtime->price;

        return view('bookings.payment', [
            'showtime'    => $showtime,
            'seats'       => $request->seats,
            'total_price' => $totalPrice,
        ]);
    }

    /* ===================== STEP 3: STORE (FINAL) ===================== */

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string|max:5',
            'total_price' => 'required|numeric|min:0',
        ]);

        $showtime = Showtime::findOrFail($request->showtime_id);

        if ($showtime->start_time < now()) {
            return back()->with('error', '⚠️ Suất chiếu đã qua!');
        }

        $exists = Booking::where('showtime_id', $request->showtime_id)
            ->where('seats', $request->seats)
            ->exists();

        if ($exists) {
            return back()->with('error', '⚠️ Ghế đã bị người khác đặt!');
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
        if (Auth::user()->role === 'client' && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    /* ===================== ADMIN ===================== */

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
            abort(403);
        }
    }
}
