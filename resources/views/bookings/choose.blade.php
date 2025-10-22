@extends('layouts.app')

@section('content')
<h1>🎬 Chọn suất chiếu để đặt vé</h1>

<div class="col-md-5">
    <div class="top_1m">
        <br>
        <form action="{{ route('bookings.choose') }}" method="GET" class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" 
                class="form-control bg-black text-white" placeholder="Tìm suất chiếu...">
            <button class="btn text-white bg_red rounded-0 border-0" type="submit">Tìm</button>
        </form>
        <br>
    </div>
</div>

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
