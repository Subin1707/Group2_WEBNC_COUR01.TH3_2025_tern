@extends('layouts.app')

@section('content')

@php
    // ✅ $seats LÀ ARRAY
    $seatArray = $seats;
    $seatCount = count($seatArray);
    $totalPrice = $showtime->price * $seatCount;
@endphp

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <h4>
            <i class="fa fa-credit-card col_red me-1"></i>
            Xác nhận <span class="col_red">Thanh toán</span>
        </h4>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">

        <h5 class="mb-3">🎬 Thông tin suất chiếu</h5>

        <ul class="list-group mb-3">
            <li class="list-group-item">
                <strong>Phim:</strong> {{ $showtime->movie->title }}
            </li>

            <li class="list-group-item">
                <strong>Ngày giờ:</strong>
                {{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}
            </li>

            <li class="list-group-item">
                <strong>Phòng:</strong> {{ $showtime->room->name }}
            </li>

            <li class="list-group-item">
                <strong>Ghế:</strong>
                {{ implode(', ', $seatArray) }}
            </li>

            <li class="list-group-item">
                <strong>Số vé:</strong> {{ $seatCount }}
            </li>

            <li class="list-group-item">
                <strong>Giá / vé:</strong>
                {{ number_format($showtime->price) }} ₫
            </li>
        </ul>

        <h4 class="text-end text-danger">
            💰 Tổng tiền: {{ number_format($totalPrice) }} ₫
        </h4>
    </div>
</div>

{{-- 🔥 FORM THANH TOÁN --}}
<form action="{{ route('bookings.store') }}" method="POST">
    @csrf

    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
    <input type="hidden" name="seats" value="{{ implode(',', $seatArray) }}">
    <input type="hidden" name="total_price" value="{{ $totalPrice }}">

    {{-- 💳 PHƯƠNG THỨC THANH TOÁN --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">💳 Phương thức thanh toán</h5>

            <div class="form-check mb-2">
                <input class="form-check-input"
                       type="radio"
                       name="payment_method"
                       value="cash"
                       id="pay_cash"
                       checked>
                <label class="form-check-label" for="pay_cash">
                    💵 Thanh toán tiền mặt tại quầy
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input"
                       type="radio"
                       name="payment_method"
                       value="transfer"
                       id="pay_transfer">
                <label class="form-check-label" for="pay_transfer">
                    🏦 Chuyển khoản / Ví điện tử
                </label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('bookings.create', $showtime->id) }}" class="btn btn-secondary">
            ← Quay lại chọn ghế
        </a>

        <button type="submit" class="btn btn-success">
            ✅ Xác nhận & Đặt vé
        </button>
    </div>
</form>

@endsection
