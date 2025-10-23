@extends('layouts.app')

@section('content')
<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <div class="trend_1l">
            <h4 class="mb-0">
                <i class="fa fa-ticket align-middle col_red me-1"></i>
                Đặt vé cho: <span class="col_red">{{ $showtime->movie->title ?? 'N/A' }}</span>
            </h4>
        </div>
    </div>
</div>

@if (session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
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

<form action="{{ route('bookings.store') }}" method="POST" class="mt-4">
    @csrf
    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
    <input type="hidden" id="ticket_price" value="{{ $showtime->price ?? 0 }}">

    <div class="mb-3">
        <label for="seat_row" class="form-label">Hàng ghế (A–F)</label>
        <select id="seat_row" class="form-select" required>
            <option value="">-- Chọn hàng --</option>
            @foreach (range('A', 'F') as $row)
                <option value="{{ $row }}">{{ $row }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="seat_number" class="form-label">Số ghế (1–10)</label>
        <select id="seat_number" class="form-select" required>
            <option value="">-- Chọn số --</option>
            @foreach (range(1, 10) as $num)
                <option value="{{ $num }}">{{ $num }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="seat" class="form-label">Ghế đã chọn</label>
        <input type="text" id="seat" name="seats" class="form-control" 
               readonly required placeholder="Sẽ hiển thị sau khi chọn hàng và số">
    </div>

    <div class="mb-3">
        <label for="total_price" class="form-label">Giá vé (VNĐ)</label>
        <input type="number" id="total_price" name="total_price" class="form-control" 
               value="{{ $showtime->price ?? 0 }}" readonly required>
    </div>

    <button type="submit" class="btn btn-success">Đặt vé</button>
</form>

<script>
    const seatRow = document.getElementById('seat_row');
    const seatNumber = document.getElementById('seat_number');
    const seatInput = document.getElementById('seat');
    const ticketPrice = parseFloat(document.getElementById('ticket_price').value) || 0;
    const totalPrice = document.getElementById('total_price');

    function updateSeat() {
        const row = seatRow.value;
        const number = seatNumber.value;

        if (row && number) {
            seatInput.value = row + number;
            totalPrice.value = ticketPrice;
        } else {
            seatInput.value = '';
            totalPrice.value = 0;
        }
    }
    seatRow.addEventListener('change', updateSeat);
    seatNumber.addEventListener('change', updateSeat);
</script>
@endsection
