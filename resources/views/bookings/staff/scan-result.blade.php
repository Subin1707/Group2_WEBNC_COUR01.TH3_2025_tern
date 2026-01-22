@extends('layouts.app')

@section('content')
<div class="container">

    <div class="alert alert-success mb-4">
        <h4 class="mb-0">✅ Check-in thành công</h4>
        <small class="text-muted">
            Vé đã được ghi nhận vào rạp
        </small>
    </div>

    <ul class="list-group mb-4">

        <li class="list-group-item">
            <strong>👤 Khách hàng:</strong>
            {{ $booking->user->name ?? 'N/A' }}
        </li>

        <li class="list-group-item">
            <strong>🎬 Phim:</strong>
            {{ $booking->showtime->movie->title ?? 'N/A' }}
        </li>

        <li class="list-group-item">
            <strong>🕒 Suất chiếu:</strong>
            {{ optional($booking->showtime->start_time)->format('d/m/Y H:i') }}
        </li>

        <li class="list-group-item">
            <strong>🏢 Phòng:</strong>
            {{ $booking->room_code ?? ($booking->showtime->room->name ?? 'N/A') }}
        </li>

        <li class="list-group-item">
            <strong>💺 Ghế:</strong>
            {{ $booking->seats }}
        </li>

        <li class="list-group-item">
            <strong>📌 Trạng thái:</strong>
            <span class="badge bg-secondary">
                🎬 ĐÃ VÀO RẠP
            </span>
        </li>

        <li class="list-group-item">
            <strong>⏱ Thời gian check-in:</strong>
            {{ optional($booking->checked_in_at)->format('d/m/Y H:i:s') }}
        </li>

    </ul>

    <div class="d-flex gap-2">
        <a href="{{ route('staff.dashboard') }}" class="btn btn-primary">
            ⬅ Về Dashboard
        </a>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            🔁 Scan vé khác
        </a>
    </div>

</div>
@endsection
