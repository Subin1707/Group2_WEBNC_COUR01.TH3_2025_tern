@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <div class="trend_1l">
            <h4 class="mb-0">
                <i class="fa fa-history align-middle col_red me-1"></i>
                Lịch sử <span class="col_red">Đặt vé</span>
            </h4>
        </div>
    </div>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($bookings->count() == 0) <div class="alert alert-info">Bạn chưa đặt vé nào.</div>
@else

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Phim</th>
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
        <tr>
            <td>{{ $booking->id }}</td>

```
        <td>{{ $booking->showtime->movie->title ?? 'N/A' }}</td>

        <td>
            {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}
        </td>

        <td>{{ $booking->seats }}</td>

        <td>{{ number_format($booking->total_price) }} ₫</td>

        {{-- THANH TOÁN --}}
        <td>
            @switch($booking->payment_method)
                @case('cash')
                    <span class="badge bg-warning text-dark">💵 Tiền mặt</span>
                    @break
                @case('transfer')
                    <span class="badge bg-info">🏦 Chuyển khoản</span>
                    @break
                @default
                    <span class="badge bg-secondary">Chưa xác định</span>
            @endswitch
        </td>

        {{-- TRẠNG THÁI --}}
        <td>
            @php
                $class = match($booking->status) {
                    'pending' => 'badge bg-warning',
                    'confirmed' => 'badge bg-success',
                    'cancelled' => 'badge bg-danger',
                    default => 'badge bg-secondary'
                };
            @endphp
            <span class="{{ $class }}">{{ ucfirst($booking->status) }}</span>
        </td>

        <td>
            <a href="{{ route('bookings.show', $booking->id) }}"
               class="btn btn-info btn-sm">Xem</a>
        </td>
    </tr>
    @endforeach
</tbody>
```

</table>

{{ $bookings->links() }}

@endif

<a href="{{ route('bookings.choose') }}" class="btn btn-primary mt-3">
    🎟️ Đặt vé mới
</a>

@endsection
