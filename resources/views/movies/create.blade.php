@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">➕ Thêm phim mới</h1>

    {{-- Form thêm phim --}}
    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('movies._form')
    </form>

    {{-- Nút quay lại --}}
    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary mt-3">⬅️ Quay lại</a>
</div>
@endsection
