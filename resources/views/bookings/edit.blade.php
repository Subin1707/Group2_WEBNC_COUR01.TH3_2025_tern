@extends('layouts.app')

@section('content')
<h1>✏️ Sửa Booking #{{ $booking->id }}</h1>

<form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Suất chiếu</label>
        <select name="showtime_id" class="form-control">
            @foreach($showtimes as $showtime)
                <option value="{{ $showtime->id }}" {{ $showtime->id == $booking->showtime_id ? 'selected' : '' }}>
                    {{ $showtime->movie->title }} ({{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Ghế</label>
        <input type="text" name="seats" class="form-control" value="{{ $booking->seats }}" required>
    </div>

    <div class="mb-3">
        <label>Tổng tiền</label>
        <input type="number" name="total_price" class="form-control" value="{{ $booking->total_price }}" required>
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
@endsection
