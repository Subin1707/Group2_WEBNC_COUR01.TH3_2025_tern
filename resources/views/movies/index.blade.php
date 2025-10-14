@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🎬 Danh sách phim</h1>

    {{-- Chỉ admin mới được thêm phim --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary mb-3">➕ Thêm phim mới</a>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Tên phim</th>
                <th>Thể loại</th>
                <th>Thời lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->genre ?? '—' }}</td>
                    <td>{{ $movie->duration ?? '—' }} phút</td>
                    <td>
                        {{-- Ai cũng có thể xem chi tiết --}}
                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-info btn-sm">👁️ Xem</a>

                        {{-- Chỉ admin mới được sửa hoặc xóa --}}
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">✏️ Sửa</a>

                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" 
                                  method="POST" 
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Xóa phim này?')">🗑️ Xóa</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Không có phim nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $movies->links() }}
    </div>
</div>
@endsection
