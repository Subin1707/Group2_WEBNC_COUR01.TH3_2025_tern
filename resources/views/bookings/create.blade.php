@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <div class="trend_1l">
            <h4 class="mb-0">
                <i class="fa fa-ticket align-middle col_red me-1"></i>
                Đặt vé cho:
                <span class="col_red">{{ $showtime->movie->title ?? 'N/A' }}</span>
            </h4>
        </div>
    </div>
</div>

@if (session('error')) <div class="alert alert-danger mt-3">
{{ session('error') }} </div>
@endif

@if ($errors->any()) <div class="alert alert-danger mt-3"> <ul class="mb-0">
@foreach ($errors->all() as $error) <li>{{ $error }}</li>
@endforeach </ul> </div>
@endif

{{-- STEP 1: CHỌN GHẾ → SANG PAYMENT --}}

<form action="{{ route('bookings.payment.preview') }}" method="POST" class="mt-4">
    @csrf

```
<input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
<input type="hidden" id="ticket_price" value="{{ $showtime->price ?? 0 }}">

<div class="mb-3">
    <label class="form-label">Hàng ghế (A–F)</label>
    <select id="seat_row" class="form-select" required>
        <option value="">-- Chọn hàng --</option>
        @foreach (range('A', 'F') as $row)
            <option value="{{ $row }}">{{ $row }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Số ghế (1–10)</label>
    <select id="seat_number" class="form-select" required>
        <option value="">-- Chọn số --</option>
        @foreach (range(1, 10) as $num)
            <option value="{{ $num }}">{{ $num }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Ghế đã chọn</label>
    <input type="text"
           id="seat"
           name="seats"
           class="form-control"
           readonly
           required
           placeholder="Vui lòng chọn hàng và số ghế">
</div>

<button type="submit" class="btn btn-primary">
    Tiếp tục thanh toán →
</button>
```

</form>

<script>
    const seatRow = document.getElementById('seat_row');
    const seatNumber = document.getElementById('seat_number');
    const seatInput = document.getElementById('seat');

    function updateSeat() {
        if (seatRow.value && seatNumber.value) {
            seatInput.value = seatRow.value + seatNumber.value;
        } else {
            seatInput.value = '';
        }
    }

    seatRow.addEventListener('change', updateSeat);
    seatNumber.addEventListener('change', updateSeat);
</script>

@endsection
