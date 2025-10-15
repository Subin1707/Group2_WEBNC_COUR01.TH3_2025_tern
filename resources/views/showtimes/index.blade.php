@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🎬 Danh sách suất chiếu</h1>

    {{-- Chỉ admin mới được thêm suất chiếu --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary mb-3">➕ Thêm suất chiếu</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Phim</th>
                <th>Phòng chiếu</th>
                <th>Thời gian</th>
                <th>Giá vé (VNĐ)</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($showtimes as $showtime)
                <tr>
                    <td>{{ $showtime->movie->title ?? 'N/A' }}</td>
                    <td>{{ $showtime->room->name ?? 'N/A' }}</td>
                    <td>{{ date('d/m/Y H:i', strtotime($showtime->start_time)) }}</td>
                    <td>{{ number_format($showtime->price, 0, ',', '.') }}</td>
                    <td>
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('admin.showtimes.show', $showtime->id) }}" class="btn btn-info btn-sm">👁 Xem</a>
                            <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="btn btn-warning btn-sm">✏️ Sửa</a>
                            <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa suất chiếu này?')">🗑 Xóa</button>
                            </form>
                        @else
                            <a href="{{ route('showtimes.show', $showtime->id) }}" class="btn btn-info btn-sm">👁 Xem</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Không có suất chiếu nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $showtimes->links() }}
</div>
@endsection
