@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class="mb-4">🆘 Tạo ticket hỗ trợ</h4>

```
<form method="POST" action="{{ route('support.store') }}">
    @csrf

    {{-- Tiêu đề --}}
    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text"
               name="subject"
               class="form-control"
               value="{{ old('subject') }}"
               required>
    </div>

    {{-- Danh mục --}}
    <div class="mb-3">
        <label class="form-label">Danh mục</label>
        <select name="category" class="form-control" required>
            <option value="">-- Chọn danh mục --</option>
            <option value="booking" {{ old('category')=='booking' ? 'selected' : '' }}>
                Vé / Booking
            </option>
            <option value="payment" {{ old('category')=='payment' ? 'selected' : '' }}>
                Thanh toán
            </option>
            <option value="movie" {{ old('category')=='movie' ? 'selected' : '' }}>
                Phim
            </option>
            <option value="theater" {{ old('category')=='theater' ? 'selected' : '' }}>
                Rạp
            </option>
            <option value="other" {{ old('category')=='other' ? 'selected' : '' }}>
                Khác
            </option>
        </select>
    </div>

    {{-- Booking liên quan --}}
    <div class="mb-3">
        <label class="form-label">Booking liên quan (nếu có)</label>
        <select name="booking_id" class="form-control">
            <option value="">-- Không --</option>
            @foreach($bookings as $booking)
                <option value="{{ $booking->id }}"
                    {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                    #{{ $booking->id }} – {{ $booking->showtime->movie->title }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Nội dung --}}
    <div class="mb-3">
        <label class="form-label">Nội dung</label>
        <textarea name="message"
                  rows="4"
                  class="form-control"
                  required>{{ old('message') }}</textarea>
    </div>

    <button class="btn btn-success">
        📩 Gửi yêu cầu
    </button>
</form>
```

</div>
@endsection
