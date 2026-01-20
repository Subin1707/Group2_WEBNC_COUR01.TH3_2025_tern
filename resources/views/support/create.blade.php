@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">🆘 Tạo ticket hỗ trợ</h4>

    <form method="POST" action="{{ route('support.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category" class="form-control" required>
                <option value="booking">Vé / Booking</option>
                <option value="payment">Thanh toán</option>
                <option value="account">Tài khoản</option>
                <option value="other">Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Booking liên quan (nếu có)</label>
            <select name="booking_id" class="form-control">
                <option value="">-- Không --</option>
                @foreach($bookings as $booking)
                    <option value="{{ $booking->id }}">
                        #{{ $booking->id }} – {{ $booking->showtime->movie->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea name="message" rows="4" class="form-control" required></textarea>
        </div>

        <button class="btn btn-success">
            📩 Gửi yêu cầu
        </button>
    </form>
</div>
@endsection
