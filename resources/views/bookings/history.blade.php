@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <h4 class="mb-0">
            <i class="fa fa-history col_red me-1"></i>
            Lịch sử <span class="col_red">Đặt vé</span>
        </h4>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($bookings->isEmpty())
    <div class="alert alert-info">Bạn chưa đặt vé nào.</div>
@else

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Phim</th>
            <th>Phòng</th> {{-- ✅ THÊM --}}
            <th>Ngày giờ</th>
            <th>Ghế</th>
            <th>Tổng tiền</th>
            <th>Thanh toán</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)

            {{-- 🔒 BẢO VỆ CUỐI: không phải booking của user thì SKIP --}}
            @continue($booking->user_id !== auth()->id())

            <tr>
                <td>{{ $booking->id }}</td>

                <td>
                    {{ $booking->showtime->movie->title ?? 'N/A' }}
                </td>

                {{-- ✅ PHÒNG --}}
                <td>
                    <span class="badge bg-secondary">
                        {{ $booking->showtime->room->code 
                            ?? $booking->showtime->room->name 
                            ?? 'N/A' }}
                    </span>
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}
                </td>

                <td>{{ $booking->seats }}</td>

                <td>{{ number_format($booking->total_price) }} ₫</td>

                <td>
                    @if($booking->payment_method === 'cash')
                        <span class="badge bg-warning text-dark">💵 Tiền mặt</span>
                    @elseif($booking->payment_method === 'transfer')
                        <span class="badge bg-info">🏦 Chuyển khoản</span>
                    @else
                        <span class="badge bg-secondary">N/A</span>
                    @endif
                </td>

                <td>
                    <span class="badge bg-{{ 
                        $booking->status === 'confirmed' ? 'success' : 
                        ($booking->status === 'pending' ? 'warning' : 'danger') 
                    }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>

                <td>
                    <a href="{{ route('bookings.show', $booking->id) }}"
                       class="btn btn-info btn-sm">
                        Xem
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $bookings->links() }}

@endif

<a href="{{ route('bookings.choose') }}" class="btn btn-primary mt-3">
    🎟️ Đặt vé mới
</a>

@endsection
