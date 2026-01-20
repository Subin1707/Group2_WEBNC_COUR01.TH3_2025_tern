@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">
        💬 CSKH – Ticket #{{ $ticket->id }}
        <span class="badge bg-info">{{ strtoupper($ticket->status) }}</span>
    </h4>

    {{-- Thông tin ticket --}}
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Tiêu đề:</strong> {{ $ticket->subject }}</p>
            <p><strong>Danh mục:</strong> {{ ucfirst($ticket->category) }}</p>

            @if($ticket->booking)
                <p>
                    <strong>Booking liên quan:</strong>
                    <a href="{{ route('bookings.show', $ticket->booking) }}">
                        #{{ $ticket->booking->id }}
                    </a>
                </p>
            @endif

            <p class="text-muted">
                Tạo lúc: {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- CHAT BOX --}}
    <div class="card">
        <div class="card-header">
            💬 Hội thoại
        </div>

        <div class="card-body" style="height: 400px; overflow-y: auto">
            @forelse($ticket->replies as $reply)
                <div class="mb-3">
                    <strong>
                        {{ $reply->user->name }}
                        @if($reply->user->role !== 'user')
                            <span class="badge bg-secondary">
                                {{ strtoupper($reply->user->role) }}
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
                <p class="text-muted">Chưa có phản hồi nào.</p>
            @endforelse
        </div>

        {{-- FORM GỬI TIN --}}
        @if($ticket->status !== 'closed')
        <div class="card-footer">
            <form method="POST" action="{{ route('support.replies.store', $ticket) }}">
                @csrf
                <textarea name="message"
                          class="form-control mb-2"
                          rows="2"
                          placeholder="Nhập tin nhắn..."
                          required></textarea>

                <button class="btn btn-primary w-100">
                    📩 Gửi phản hồi
                </button>
            </form>
        </div>
        @else
            <div class="card-footer text-center text-muted">
                🔒 Ticket đã đóng
            </div>
        @endif
    </div>
</div>
@endsection
