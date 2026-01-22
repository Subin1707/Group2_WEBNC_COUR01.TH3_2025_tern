@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3 text-success">✅ Check-in thành công</h3>

    <ul class="list-group mb-3">
        <li class="list-group-item">
            <strong>👤 Khách hàng:</strong> {{ $booking->user->name }}
        </li>

        <li class="list-group-item">
            <strong>🎬 Phim:</strong> {{ $booking->showtime->movie->title }}
        </li>

        <li class="list-group-item">
            <strong>🕒 Suất chiếu:</strong>
            {{ $booking->showtime->start_time->format('d/m/Y H:i') }}
        </li>

        <li class="list-group-item">
            <strong>🏢 Phòng:</strong>
            {{ $booking->room_code ?? $booking->showtime->room->name }}
        </li>

        <li class="list-group-item">
            <strong>💺 Ghế:</strong> {{ $booking->seats }}
        </li>

        <li class="list-group-item">
            <strong>📌 Trạng thái:</strong>
            <span class="badge bg-success">ĐÃ VÀO RẠP</span>
        </li>
    </ul>

    <a href="{{ route('staff.dashboard') }}" class="btn btn-primary">
        ⬅ Về Dashboard
    </a>
</div>
@endsection
