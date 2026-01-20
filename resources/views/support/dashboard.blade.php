@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class="mb-4">📊 Dashboard Chăm sóc khách hàng</h4>

```
<div class="row g-3">

    {{-- Ticket mở --}}
    <div class="col-md-3">
        <div class="card border-warning shadow-sm text-center">
            <div class="card-body">
                <h2 class="text-warning">{{ $stats['open'] }}</h2>
                <p class="mb-0 fw-semibold">Ticket mở</p>
            </div>
        </div>
    </div>

    {{-- Đang xử lý --}}
    <div class="col-md-3">
        <div class="card border-primary shadow-sm text-center">
            <div class="card-body">
                <h2 class="text-primary">{{ $stats['processing'] }}</h2>
                <p class="mb-0 fw-semibold">Đang xử lý</p>
            </div>
        </div>
    </div>

    {{-- Đã phản hồi --}}
    <div class="col-md-3">
        <div class="card border-success shadow-sm text-center">
            <div class="card-body">
                <h2 class="text-success">{{ $stats['answered'] }}</h2>
                <p class="mb-0 fw-semibold">Đã phản hồi</p>
            </div>
        </div>
    </div>

    {{-- Đã đóng --}}
    <div class="col-md-3">
        <div class="card border-secondary shadow-sm text-center">
            <div class="card-body">
                <h2 class="text-secondary">{{ $stats['closed'] }}</h2>
                <p class="mb-0 fw-semibold">Đã đóng</p>
            </div>
        </div>
    </div>

</div>

{{-- QUICK ACTION --}}
<div class="mt-4">
    <a href="{{ route('support.staff.index') }}"
       class="btn btn-outline-primary me-2">
        📋 Danh sách ticket
    </a>

    @if(auth()->user()->isAdmin())
        <a href="{{ route('support.admin.index') }}"
           class="btn btn-outline-dark">
            🛠 Quản lý toàn bộ ticket
        </a>
    @endif
</div>
```

</div>
@endsection
