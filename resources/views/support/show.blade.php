@extends('layouts.app')

@section('content')
<div class="container">

    {{-- TIÊU ĐỀ --}}
    <h4 class="mb-3">
        💬 CSKH – Ticket #{{ $ticket->id }}
        <span class="badge bg-info">
            {{ strtoupper($ticket->status) }}
        </span>
    </h4>

    {{-- THÔNG TIN TICKET --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <p class="mb-1">
                <strong>Tiêu đề:</strong> {{ $ticket->subject }}
            </p>

            <p class="mb-1">
                <strong>Danh mục:</strong> {{ ucfirst($ticket->category) }}
            </p>

            @if ($ticket->booking)
                <p class="mb-1">
                    <strong>Booking liên quan:</strong>
                    <a href="{{ route('bookings.show', $ticket->booking) }}">
                        #{{ $ticket->booking->id }}
                    </a>
                </p>
            @endif

            <p class="text-muted mb-0">
                Tạo lúc: {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- CHAT BOX --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">
            💬 Hội thoại
        </div>

        <div class="card-body" style="height: 400px; overflow-y: auto">

            @forelse ($ticket->replies as $reply)
                <div class="mb-3">

                    <strong>
                        {{ $reply->user->name }}

                        @if ($reply->user->role !== 'user')
                            <span class="badge bg-secondary ms-1">
                                {{ strtoupper($reply->user->role) }}
                            </span>
                        @else
                            <span class="badge bg-primary ms-1">
                                BẠN
                            </span>
                        @endif
                    </strong>

                    <div class="mt-1">
                        {{ $reply->message }}
                    </div>

                    <div class="text-muted small">
                        {{ $reply->created_at->format('d/m/Y H:i') }}
                    </div>

                </div>
                <hr>
            @empty
                <p class="text-muted text-center mb-0">
                    Chưa có phản hồi nào từ CSKH.
                </p>
            @endforelse

        </div>

        {{-- LOGIC KIỂM SOÁT FLOW --}}
        @php
            $hasStaffReply = $ticket->replies
                ->filter(fn($r) => $r->user && $r->user->role !== 'user')
                ->count() > 0;
        @endphp

        {{-- FORM GỬI PHẢN HỒI --}}
        @if ($ticket->status === 'closed')
            <div class="card-footer text-center text-muted">
                🔒 Ticket đã đóng
            </div>

        @elseif (! $hasStaffReply)
            <div class="card-footer text-center text-muted">
                ⏳ Vui lòng chờ nhân viên CSKH phản hồi
            </div>

        @else
            <div class="card-footer">
                <form method="POST" action="{{ route('support.reply', $ticket) }}">
                    @csrf

                    <textarea
                        name="message"
                        class="form-control mb-2"
                        rows="2"
                        placeholder="Nhập phản hồi của bạn..."
                        required
                    ></textarea>

                    <button type="submit" class="btn btn-primary w-100">
                        📩 Gửi phản hồi
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
@endsection
