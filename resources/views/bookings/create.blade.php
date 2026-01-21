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

{{-- ERROR --}}
@if (session('error'))
    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('bookings.payment.preview') }}" method="POST" class="mt-4">
    @csrf

    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">

    {{-- HÀNG GHẾ --}}
    <div class="mb-3">
        <label class="form-label">Hàng ghế (A–F)</label>
        <select id="seat_row" class="form-select">
            <option value="">-- Chọn hàng --</option>
            @foreach (range('A', 'F') as $row)
                <option value="{{ $row }}">{{ $row }}</option>
            @endforeach
        </select>
    </div>

    {{-- SỐ GHẾ --}}
    <div class="mb-3">
        <label class="form-label">Số ghế (1–10)</label>
        <select id="seat_number" class="form-select">
            <option value="">-- Chọn số --</option>
            @foreach (range(1, 10) as $num)
                <option value="{{ $num }}">{{ $num }}</option>
            @endforeach
        </select>
    </div>

    {{-- GHẾ ĐÃ CHỌN --}}
    <div class="mb-3">
        <label class="form-label">Ghế đã chọn</label>
        <input type="text"
               id="seat"
               name="seats"
               class="form-control"
               readonly
               required
               placeholder="Chưa chọn ghế">
    </div>

    {{-- THÔNG TIN VÉ --}}
    <div class="mb-3">
        <p>
            🎟 <strong>Số lượng vé:</strong>
            <span id="ticketCount">0</span>
        </p>
        <p class="fw-bold text-danger">
            💰 Tổng tiền:
            <span id="totalPrice">0</span> ₫
        </p>
    </div>

    <button type="submit" class="btn btn-primary">
        Tiếp tục thanh toán →
    </button>
</form>

{{-- SCRIPT CHỌN NHIỀU GHẾ --}}
<script>
    const seatRow = document.getElementById('seat_row');
    const seatNumber = document.getElementById('seat_number');
    const seatInput = document.getElementById('seat');
    const ticketCountEl = document.getElementById('ticketCount');
    const totalPriceEl = document.getElementById('totalPrice');

const pricePerTicket = Number("{{ $showtime->price }}");
    let selectedSeats = [];

    function updateDisplay() {
        seatInput.value = selectedSeats.join(',');
        ticketCountEl.innerText = selectedSeats.length;
        totalPriceEl.innerText =
            (selectedSeats.length * pricePerTicket).toLocaleString('vi-VN');
    }

    seatNumber.addEventListener('change', function () {
        if (!seatRow.value || !seatNumber.value) return;

        const seat = seatRow.value + seatNumber.value;

        if (selectedSeats.includes(seat)) {
            alert('❌ Ghế này đã được chọn');
            seatNumber.value = '';
            return;
        }

        selectedSeats.push(seat);
        updateDisplay();

        // reset để chọn tiếp
        seatNumber.value = '';
    });
</script>

@endsection
