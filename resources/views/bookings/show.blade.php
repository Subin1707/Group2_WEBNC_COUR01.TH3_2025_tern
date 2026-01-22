@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <h4 class="mb-0">
            <i class="fa fa-ticket col_red me-1"></i>
            Chi tiết <span class="col_red">Vé #{{ $booking->id }}</span>
        </h4>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item">
                <strong>👤 Khách hàng:</strong>
                {{ $booking->user->name ?? 'N/A' }}
            </li>

            <li class="list-group-item">
                <strong>🎬 Phim:</strong>
                {{ $booking->showtime->movie->title ?? 'N/A' }}
            </li>

            <li class="list-group-item">
                <strong>🕒 Ngày giờ:</strong>
                {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}
            </li>

            <li class="list-group-item">
                <strong>🏢 Phòng chiếu:</strong>
                {{ $booking->showtime->room->name ?? 'N/A' }}
                @if(isset($booking->showtime->room->code))
                    (Mã: {{ $booking->showtime->room->code }})
                @endif
            </li>

            <li class="list-group-item">
                <strong>💺 Ghế:</strong>
                {{ $booking->seats }}
            </li>

            <li class="list-group-item">
                <strong>💰 Tổng tiền:</strong>
                {{ number_format($booking->total_price) }} ₫
            </li>

            <li class="list-group-item">
                <strong>💳 Thanh toán:</strong>
                @if($booking->payment_method === 'cash')
                    <span class="badge bg-warning text-dark">💵 Tiền mặt</span>
                @else
                    <span class="badge bg-info">🏦 Chuyển khoản</span>
                @endif
            </li>

            <li class="list-group-item">
                <strong>📌 Trạng thái:</strong>
                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </li>
        </ul>

        {{-- ================= QR CODE ================= --}}
        @if($booking->status === 'confirmed')
            <div class="text-center mb-4">
                <h5 class="mb-2">🔲 QR Code Vé</h5>
                {!! QrCode::size(200)->generate(route('bookings.show', $booking->id)) !!}
                <p class="text-muted mt-2">Xuất trình mã QR khi vào rạp</p>
            </div>
        @endif

        {{-- ================= ACTIONS ================= --}}
        <div class="d-flex flex-wrap gap-2">

            {{-- USER --}}
            @if(Auth::id() === $booking->user_id && $booking->status === 'confirmed')
                <a href="{{ route('bookings.exportPdf', $booking->id) }}"
                   class="btn btn-danger">
                    📄 Xuất vé PDF
                </a>
            @endif

            {{-- STAFF --}}
            @if(Auth::user()->role === 'staff' && $booking->status === 'pending')
                <form action="{{ route('staff.bookings.confirm', $booking->id) }}"
                      method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success">
                        ✅ Xác nhận vé
                    </button>
                </form>
            @endif

            {{-- ADMIN --}}
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                   class="btn btn-warning">
                    ✏️ Chỉnh sửa
                </a>
            @endif

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                ⬅ Quay lại
            </a>
        </div>

    </div>
</div>

@endsection
