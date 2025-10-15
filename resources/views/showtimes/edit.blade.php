@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Sửa suất chiếu</h1>

    @if(Auth::check() && Auth::user()->role === 'admin')
        {{-- Form cập nhật suất chiếu --}}
        <form action="{{ route('admin.showtimes.update', $showtime->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nhúng form chung --}}
            @include('showtimes._form', ['showtime' => $showtime])

            <div class="mt-3">
                <button type="submit" class="btn btn-success">💾 Lưu thay đổi</button>
                <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">↩ Quay lại</a>
            </div>
        </form>
    @else
        <div class="alert alert-danger">
            Bạn không có quyền truy cập trang này.
        </div>
    @endif
</div>
@endsection
