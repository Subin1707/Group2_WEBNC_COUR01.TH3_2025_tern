@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Sửa phim</h1>

    {{-- Form chỉnh sửa phim --}}
    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('movies._form')
    </form>

    {{-- Nút quay lại danh sách --}}
    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary mt-3">⬅️ Quay lại</a>
</div>
@endsection
