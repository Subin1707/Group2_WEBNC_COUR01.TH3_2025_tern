@extends('layouts.app')

@section('content')
<h1>🎟️ Đặt vé cho: {{ $showtime->movie->title ?? 'N/A' }}</h1>

<form action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">

    <!-- Giá vé lấy từ showtime -->
    <input type="hidden" id="ticket_price" value="{{ $showtime->ticket_price ?? 0 }}">

    <div class="mb-3">
        <label>Ghế (VD: A1,A2)</label>
        <input type="text" id="seats" name="seats" class="form-control" required>
        <small class="text-muted">Nhập danh sách ghế, cách nhau bằng dấu phẩy (,)</small>
    </div>

    <div class="mb-3">
        <label>Tổng tiền (VNĐ)</label>
        <input type="number" id="total_price" name="total_price" class="form-control" readonly required>
    </div>

    <button type="submit" class="btn btn-success">Đặt vé</button>
</form>

<script>
document.getElementById('seats').addEventListener('input', function () {
    const seatsInput = this.value.trim();
    const seatArray = seatsInput ? seatsInput.split(',') : [];
    const seatCount = seatArray.filter(s => s.trim() !== '').length;

    const ticketPrice = parseFloat(document.getElementById('ticket_price').value) || 0;
    const total = seatCount * ticketPrice;

    document.getElementById('total_price').value = total;
});
</script>
@endsection
