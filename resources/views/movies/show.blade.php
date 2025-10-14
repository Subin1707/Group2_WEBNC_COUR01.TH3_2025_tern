@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $movie->title }}</h1>

    {{-- Hiển thị poster nếu có --}}
    @if($movie->poster)
        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="img-fluid mb-3">
    @endif

    {{-- Mô tả phim --}}
    <p>{{ $movie->description ?? 'Không có mô tả' }}</p>

    {{-- Thông tin chi tiết --}}
    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Thể loại:</strong> {{ $movie->genre ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Thời lượng:</strong> {{ $movie->duration ?? 'N/A' }} phút</li>
        <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $movie->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Ngày cập nhật:</strong> {{ $movie->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</li>
    </ul>

    {{-- Nút quay lại danh sách phim client --}}
    <a href="{{ route('movies.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
</div>
@endsection
