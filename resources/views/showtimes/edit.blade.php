@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Sửa suất chiếu</h1>

    {{-- Form cập nhật suất chiếu --}}
    <form action="{{ route('admin.showtimes.update', $showtime->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.showtimes._form', ['showtime' => $showtime])

        <div class="mt-3">
            <button type="submit" class="btn btn-success">💾 Lưu thay đổi</button>
            <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">↩ Quay lại</a>
        </div>
    </form>
</div>
@endsection
