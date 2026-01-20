<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    /* ================= USER ================= */

    // User xem danh sách ticket của mình
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('support.user.index', compact('tickets'));
    }

    // Form tạo ticket
    public function create()
    {
        return view('support.user.create');
    }

    // Lưu ticket mới
    public function store(Request $request)
    {
        $request->validate([
            'subject'    => 'required|string|max:255',
            'category'   => 'required|in:booking,payment,movie,theater,other',
            'message'    => 'required|string',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);

        $ticket = SupportTicket::create([
            'user_id'    => Auth::id(),
            'booking_id' => $request->booking_id,
            'subject'    => $request->subject,
            'category'   => $request->category,
            'message'    => $request->message,
            'status'     => 'open',
        ]);

        // Reply đầu tiên
        $ticket->replies()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('support.index')
            ->with('success', '🎫 Đã gửi yêu cầu hỗ trợ');
    }

    // User xem chi tiết ticket
    public function show(SupportTicket $ticket)
    {
        $this->authorizeUserTicket($ticket);

        return view('support.user.show', compact('ticket'));
    }

    /* ================= STAFF ================= */

    public function staffIndex()
    {
        $this->authorizeStaff();

        $tickets = SupportTicket::where(function ($q) {
                $q->where('assigned_to', Auth::id())
                  ->orWhereNull('assigned_to');
            })
            ->orderByRaw('assigned_to IS NULL DESC')
            ->latest()
            ->paginate(10);

        return view('support.staff.index', compact('tickets'));
    }

    public function staffShow(SupportTicket $ticket)
    {
        $this->authorizeStaff();

        return view('support.staff.show', compact('ticket'));
    }

    /* ================= ADMIN ================= */

    public function adminIndex()
    {
        $this->authorizeAdmin();

        $tickets = SupportTicket::latest()->paginate(15);

        return view('support.admin.index', compact('tickets'));
    }

    public function adminShow(SupportTicket $ticket)
    {
        $this->authorizeAdmin();

        return view('support.admin.show', compact('ticket'));
    }

    // Admin phân công ticket
    public function assign(Request $request, SupportTicket $ticket)
    {
        $this->authorizeAdmin();

        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'assigned_to' => $request->assigned_to,
            'status'      => 'processing',
        ]);

        return back()->with('success', '👨‍💼 Đã phân công ticket');
    }

    /* ================= COMMON ================= */

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $this->authorizeStaffOrAdmin();

        $request->validate([
            'status' => 'required|in:open,processing,answered,closed',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        return back()->with('success', '✅ Đã cập nhật trạng thái');
    }

    /* ================= HELPERS ================= */

    private function authorizeUserTicket(SupportTicket $ticket): void
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
    }

    private function authorizeStaff(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isStaff() && !$user->isAdmin()) {
            abort(403);
        }
    }

    private function authorizeAdmin(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403);
        }
    }

    private function authorizeStaffOrAdmin(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isStaff() && !$user->isAdmin()) {
            abort(403);
        }
    }
}
