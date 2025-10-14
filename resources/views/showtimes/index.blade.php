@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🎬 Danh sách suất chiếu</h1>

    {{-- Chỉ admin mới được thêm suất chiếu --}}
    @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary mb-3">➕ Thêm suất chiếu</a>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Phim</th>
                <th>Phòng chiếu</th>
                <th>Thời gian chiếu</th>
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
                        {{-- Ai cũng có thể xem chi tiết --}}
                        @if(Auth::check() && Auth::user()->is_admin)
                            <a href="{{ route('admin.showtimes.show', $showtime->id) }}" class="btn btn-info btn-sm">👁 Xem</a>
                            <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="btn btn-warning btn-sm">✏️ Sửa</a>

                            <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" 
                                  method="POST" 
                                  style="display:inline;" 
                                  onsubmit="return confirm('Xóa suất chiếu này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Xóa</button>
                            </form>
                        @else
                            {{-- Client chỉ được xem chi tiết --}}
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

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $showtimes->links() }}
    </div>
</div>
@endsection
