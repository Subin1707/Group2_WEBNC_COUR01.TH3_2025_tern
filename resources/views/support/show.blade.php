@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">🎫 Chi tiết Ticket #{{ $ticket->id }}</h4>

    {{-- Thông tin chung --}}
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Tiêu đề:</strong> {{ $ticket->subject }}</p>

            <p>
                <strong>Danh mục:</strong>
                {{ ucfirst($ticket->category) }}
            </p>

            <p>
                <strong>Trạng thái:</strong>
                @if($ticket->status === 'open')
                    <span class="badge bg-warning">Mở</span>
                @elseif($ticket->status === 'processing')
                    <span class="badge bg-info">Đang xử lý</span>
                @else
                    <span class="badge bg-success">Đã đóng</span>
                @endif
            </p>

            <p>
                <strong>Ngày tạo:</strong>
                {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- Booking liên quan --}}
    @if($ticket->booking)
        <div class="card mb-3">
            <div class="card-header">🎬 Booking liên quan</div>
            <div class="card-body">
                <p>
                    <strong>Mã booking:</strong>
                    #{{ $ticket->booking->id }}
                </p>

                <p>
                    <strong>Phim:</strong>
                    {{ $ticket->booking->showtime->movie->title }}
                </p>

                <p>
                    <strong>Suất chiếu:</strong>
                    {{ $ticket->booking->showtime->start_time }}
                </p>
            </div>
        </div>
    @endif

    {{-- Nội dung ticket --}}
    <div class="card mb-3">
        <div class="card-header">📝 Nội dung phản ánh</div>
        <div class="card-body">
            {{ $ticket->message }}
        </div>
    </div>

    {{-- Nút quay lại --}}
    <a href="{{ route('support.index') }}" class="btn btn-secondary">
        ← Quay lại danh sách
    </a>
</div>
@endsection
