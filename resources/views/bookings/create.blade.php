@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <h4>
            <i class="fa fa-ticket col_red me-1"></i>
            Đặt vé cho:
            <span class="col_red">{{ $showtime->movie->title }}</span>
        </h4>
        <small>
            Phòng: <strong>{{ $showtime->room->name }}</strong> |
            Suất chiếu: {{ $showtime->start_time }}
        </small>
    </div>
</div>

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('bookings.payment.preview') }}"
      method="POST"
      id="bookingForm"
      data-price="{{ $showtime->price }}">

    @csrf

    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
    <input type="hidden" name="seats" id="seats">

    {{-- WRAPPER --}}
    <div class="seat-wrapper">

        {{-- SCREEN --}}
        <div class="screen">MÀN HÌNH</div>

        {{-- SEAT MAP --}}
        <div class="seat-map mb-4">

            @php
                $rows = max(1, (int) $showtime->room->seat_rows);
                $cols = max(1, (int) $showtime->room->seat_cols);
            @endphp

            @for ($r = 0; $r < $rows; $r++)
                @php $rowLabel = chr(65 + $r); @endphp

                <div class="seat-row">
                    <span class="row-label">{{ $rowLabel }}</span>

                    @for ($c = 1; $c <= $cols; $c++)
                        @php
                            $code = $rowLabel . $c;
                            $isOccupied = in_array($code, $occupiedSeats ?? []);
                        @endphp

                        <div class="seat {{ $isOccupied ? 'occupied' : '' }}"
                             data-seat="{{ $code }}">
                            {{ $c }}
                        </div>
                    @endfor
                </div>
            @endfor

        </div>
    </div>

    {{-- INFO --}}
    <div class="mb-3 text-center">
        🎟 <strong>Số vé:</strong>
        <span id="ticketCount">0</span><br>
        💰 <strong>Tổng tiền:</strong>
        <span id="totalPrice">0</span> ₫
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary px-4">
            Tiếp tục thanh toán →
        </button>
    </div>
</form>

{{-- STYLE --}}
<style>
/* ===== WRAPPER ===== */
.seat-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* ===== SCREEN ===== */
.screen {
    width: 60%;
    text-align: center;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 16px;
    padding: 8px 0;
    border-radius: 20px;
    background: linear-gradient(to bottom, #eee, #bbb);
    color: #000;
}

/* ===== SEAT MAP ===== */
.seat-map {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* ===== ROW ===== */
.seat-row {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ===== ROW LABEL ===== */
.row-label {
    width: 30px;
    text-align: right;
    font-weight: bold;
    margin-right: 6px;
}

/* ===== SEAT ===== */
.seat {
    width: 36px;
    height: 36px;
    background: #7c4dff;
    color: #fff;
    text-align: center;
    line-height: 36px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 12px;
    user-select: none;
    transition: all 0.2s ease;
}

/* Hover */
.seat:not(.occupied):hover {
    transform: scale(1.1);
    opacity: 0.9;
}

/* Selected */
.seat.selected {
    background: #e53935;
}

/* Occupied */
.seat.occupied {
    background: #9e9e9e;
    cursor: not-allowed;
    opacity: 0.5;
}
</style>

{{-- SCRIPT --}}
<script>
const seats = document.querySelectorAll('.seat');
const seatInput = document.getElementById('seats');
const ticketCount = document.getElementById('ticketCount');
const totalPrice = document.getElementById('totalPrice');
const form = document.getElementById('bookingForm');

const pricePerTicket = Number(form.dataset.price);
let selectedSeats = [];

seats.forEach(seat => {
    seat.addEventListener('click', function () {

        if (this.classList.contains('occupied')) return;

        const code = this.dataset.seat;

        if (selectedSeats.includes(code)) {
            selectedSeats = selectedSeats.filter(s => s !== code);
            this.classList.remove('selected');
        } else {
            selectedSeats.push(code);
            this.classList.add('selected');
        }

        seatInput.value = selectedSeats.join(',');
        ticketCount.innerText = selectedSeats.length;
        totalPrice.innerText =
            (selectedSeats.length * pricePerTicket).toLocaleString('vi-VN');
    });
});

form.addEventListener('submit', function (e) {
    if (selectedSeats.length === 0) {
        e.preventDefault();
        alert('⚠️ Vui lòng chọn ít nhất 1 ghế');
    }
});
</script>

@endsection
