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

    {{-- SCREEN --}}
    <div class="text-center fw-bold mb-2">MÀN HÌNH</div>

    {{-- SEAT MAP --}}
    <div class="seat-map mb-4">

        @php
            // ✅ CHỐNG NULL / 0 → LUÔN HIỆN GHẾ
            $rows = max(1, (int) $showtime->room->seat_rows);
            $cols = max(1, (int) $showtime->room->seat_cols);
        @endphp

        @for ($r = 0; $r < $rows; $r++)
            @php
                $rowLabel = chr(65 + $r); // A, B, C...
            @endphp

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

    {{-- INFO --}}
    <div class="mb-3">
        🎟 <strong>Số vé:</strong>
        <span id="ticketCount">0</span><br>
        💰 <strong>Tổng tiền:</strong>
        <span id="totalPrice">0</span> ₫
    </div>

    <button type="submit" class="btn btn-primary">
        Tiếp tục thanh toán →
    </button>
</form>

{{-- STYLE --}}
<style>
.seat-map {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.seat-row {
    display: flex;
    align-items: center;
    gap: 6px;
}
.row-label {
    width: 28px;
    font-weight: bold;
}
.seat {
    width: 34px;
    height: 34px;
    background: #7c4dff;
    color: #fff;
    text-align: center;
    line-height: 34px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    user-select: none;
}
.seat.selected {
    background: #e53935;
}
.seat.occupied {
    background: #9e9e9e;
    cursor: not-allowed;
    opacity: 0.6;
}
.seat:not(.occupied):hover {
    opacity: 0.85;
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
