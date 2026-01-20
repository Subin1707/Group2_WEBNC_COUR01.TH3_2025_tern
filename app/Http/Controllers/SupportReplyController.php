<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportReplyController extends Controller
{
    public function store(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = Auth::user();

        /* ================= AUTHORIZATION ================= */

        // User chỉ được reply ticket của chính mình
        if ($user->isUser() && $ticket->user_id !== $user->id) {
            abort(403);
        }

        // Staff chỉ được reply ticket được assign cho mình
        if ($user->isStaff()
            && $ticket->assigned_to !== null
            && $ticket->assigned_to !== $user->id
        ) {
            abort(403);
        }

        /* ================= CREATE REPLY ================= */

        $ticket->replies()->create([
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        /* ================= UPDATE STATUS ================= */

        // Staff / Admin trả lời → chuyển trạng thái hợp lệ
        if ($user->isStaff() || $user->isAdmin()) {
            if (in_array($ticket->status, ['open', 'processing'])) {
                $ticket->update([
                    'status' => 'answered',
                ]);
            }
        }

        return back()->with('success', '💬 Đã gửi phản hồi');
    }
}
