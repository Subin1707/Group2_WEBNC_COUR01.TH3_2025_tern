@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <div class="trend_1l">
            <h4 class="mb-0">
                <i class="fa fa-credit-card col_red me-1"></i>
                Xác nhận <span class="col_red">Thanh toán</span>
            </h4>
        </div>
    </div>
</div>

@if (session('error')) <div class="alert alert-danger">
{{ session('error') }} </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">🎬 Thông tin suất chiếu</h5>

```
    <ul class="list-group mb-3">
        <li class="list-group-item">
            <strong>Phim:</strong> {{ $showtime->movie->title ?? 'N/A' }}
        </li>

        <li class="list-group-item">
            <strong>Ngày giờ:</strong>
            {{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}
        </li>

        <li class="list-group-item">
            <strong>Phòng:</strong> {{ $showtime->room->name ?? 'N/A' }}
        </li>

        <li class="list-group-item">
            <strong>Ghế:</strong> {{ $seats }}
        </li>

        <li class="list-group-item">
            <strong>Giá vé:</strong>
            {{ number_format($showtime->price) }} ₫
        </li>
    </ul>

    <h4 class="text-end text-danger">
        Tổng tiền: {{ number_format($showtime->price) }} ₫
    </h4>
</div>
```

</div>

{{-- STEP 3: TẠO BOOKING THẬT --}}

<form action="{{ route('bookings.store') }}" method="POST">
    @csrf

```
<input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
<input type="hidden" name="seats" value="{{ $seats }}">
<input type="hidden" name="total_price" value="{{ $showtime->price }}">

<div class="d-flex justify-content-between">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        ← Quay lại chọn ghế
    </a>

    <button type="submit" class="btn btn-success">
        ✅ Xác nhận & Đặt vé
    </button>
</div>
```

</form>

@endsection
