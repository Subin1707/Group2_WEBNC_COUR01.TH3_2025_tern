@extends('layouts.app')

@section('content')
<h1>🎫 Chi tiết Booking #{{ $booking->id }}</h1>

<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Khách hàng:</strong> {{ $booking->user->name ?? 'N/A' }}</li>
    <li class="list-group-item"><strong>Phim:</strong> {{ $booking->showtime->movie->title ?? 'N/A' }}</li>
    <li class="list-group-item"><strong>Ngày giờ:</strong> {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}</li>
    <li class="list-group-item"><strong>Ghế:</strong> {{ $booking->seats }}</li>
    <li class="list-group-item"><strong>Tổng tiền:</strong> {{ number_format($booking->total_price) }} ₫</li>
    <li class="list-group-item"><strong>Trạng thái:</strong> {{ ucfirst($booking->status) }}</li>
</ul>

@if(Auth::user()->role === 'admin')
    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning">✏️ Sửa</a>
@endif
<a href="{{ route('bookings.index') }}" class="btn btn-secondary">⬅ Quay lại</a>
@endsection
