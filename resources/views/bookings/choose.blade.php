@extends('layouts.app')

@section('content')
<h1>🎬 Chọn suất chiếu để đặt vé</h1>

@if($showtimes->count() == 0)
    <div class="alert alert-info">Hiện chưa có suất chiếu nào.</div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Phim</th>
            <th>Phòng chiếu</th>
            <th>Ngày giờ</th>
            <th>Giá vé</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($showtimes as $showtime)
        <tr>
            <td>{{ $showtime->movie->title ?? 'N/A' }}</td>
            <td>{{ $showtime->room->name ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}</td>
            <td>{{ number_format($showtime->price) }} ₫</td>
            <td>
                <a href="{{ route('bookings.create', $showtime->id) }}" class="btn btn-success btn-sm">Đặt vé</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- 🔹 Thêm phân trang ở đây --}}
<div class="mt-3 d-flex justify-content-center">
    {{ $showtimes->links('pagination::bootstrap-5') }}
</div>

@endif
@endsection
