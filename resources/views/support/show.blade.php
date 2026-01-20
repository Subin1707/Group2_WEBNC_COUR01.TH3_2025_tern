@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">
            🎫 Ticket #{{ $ticket->id }}
            @php
                $colors = [
                    'open' => 'warning',
                    'processing' => 'primary',
                    'answered' => 'success',
                    'closed' => 'secondary'
                ];
            @endphp
            <span class="badge bg-{{ $colors[$ticket->status] }}">
                {{ strtoupper($ticket->status) }}
            </span>
        </h4>

        <a href="{{ route('support.index') }}" class="btn btn-sm btn-outline-secondary">
            ← Quay lại
        </a>
    </div>

    {{-- THÔNG TIN TICKET --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body row g-4">
            <div class="col-md-6">
                <p class="mb-1 text-muted">Tiêu đề</p>
                <h6 class="fw-semibold">{{ $ticket->subject }}</h6>
            </div>

            <div class="col-md-3">
                <p class="mb-1 text-muted">Danh mục</p>
                <span class="badge bg-light text-dark">
                    {{ ucfirst($ticket->category) }}
                </span>
            </div>

            <div class="col-md-3">
                <p class="mb-1 text-muted">Ngày tạo</p>
                <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>

    {{-- BOOKING --}}
    @if($ticket->booking)
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-light fw-semibold">
            🎟 Booking liên quan
        </div>
        <div class="card-body">
            <p class="mb-1"><strong>Mã booking:</strong> #{{ $ticket->booking->id }}</p>
            <p class="mb-1"><strong>Phim:</strong> {{ $ticket->booking->showtime->movie->title }}</p>
            <p class="mb-0"><strong>Suất chiếu:</strong>
                {{ $ticket->booking->showtime->start_time->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>
    @endif

    {{-- CHAT --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light fw-semibold">
            💬 Hội thoại
        </div>

        <div class="card-body" style="max-height: 420px; overflow-y:auto">
            @forelse($ticket->replies as $reply)
                @php
                    $isMe = $reply->user_id === auth()->id();
                @endphp

                <div class="d-flex mb-3 {{ $isMe ? 'justify-content-end' : '' }}">
                    <div class="p-3 rounded-3
                        {{ $isMe ? 'bg-primary text-white' : 'bg-light' }}"
                        style="max-width: 70%">
                        <div class="fw-semibold small mb-1">
                            {{ $reply->user->name }}
                            @if($reply->user->role !== 'user')
                                <span class="badge bg-dark ms-1">
                                    {{ strtoupper($reply->user->role) }}
                                </span>
                            @endif
                        </div>

                        <div>{{ $reply->message }}</div>

                        <div class="small mt-1 opacity-75">
                            {{ $reply->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">Chưa có phản hồi</p>
            @endforelse
        </div>

        {{-- FORM --}}
        @if($ticket->status !== 'closed')
        <div class="card-footer bg-white">
            <form method="POST" action="{{ route('support.replies.store', $ticket) }}">
                @csrf
                <div class="input-group">
                    <textarea name="message"
                              class="form-control"
                              rows="2"
                              placeholder="Nhập phản hồi..."
                              required></textarea>
                    <button class="btn btn-primary">
                        Gửi
                    </button>
                </div>
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
