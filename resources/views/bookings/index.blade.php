@extends('layouts.app')

@section('content')
<h1>🎫 Danh sách Booking</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($bookings->count() == 0)
    <div class="alert alert-info">Chưa có booking nào.</div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            @if(Auth::user()->role === 'admin')
                <th>Khách hàng</th>
            @endif
            <th>Phim</th>
            <th>Ngày giờ</th>
            <th>Ghế</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            @if(Auth::user()->role === 'admin')
                <th>Hành động</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->id }}</td>
            @if(Auth::user()->role === 'admin')
                <td>{{ $booking->user->name }}</td>
            @endif
            <td>{{ $booking->showtime->movie->title ?? 'Không xác định' }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}</td>
            <td>{{ $booking->seats }}</td>
            <td>{{ number_format($booking->total_price) }} ₫</td>
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
            @if(Auth::user()->role === 'admin')
            <td>
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-info btn-sm">Xem</a>
                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

{{ $bookings->links() }}
@endif

@if(Auth::user()->role === 'client')
    <a href="{{ route('bookings.choose') }}" class="btn btn-primary">Đặt vé mới</a>
@endif
@endsection
