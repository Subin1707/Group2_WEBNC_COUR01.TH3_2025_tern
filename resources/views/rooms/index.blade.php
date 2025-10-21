@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">💺 Danh sách phòng chiếu</h1>

    
    {{-- ✅ Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ✅ Nút thêm phòng (chỉ admin) --}}
    @auth
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mb-3">
                ➕ Thêm phòng
            </a>
        @endif
    @endauth

    {{-- ✅ Bảng danh sách phòng --}}
    <table class="table table-striped table-bordered align-middle shadow-sm">
        <thead class="table-dark">
            <tr>
                <th width="25%">Tên phòng</th>
                <th width="25%">Rạp chiếu</th>
                <th width="15%">Sức chứa</th>
                <th width="35%">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->theater->name ?? 'Không có' }}</td>
                    <td>{{ $room->capacity ?? $room->seats_count ?? 'N/A' }}</td>
                    <td>
                        {{-- 👁 Nút xem (mọi người đều thấy) --}}
                        <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-info btn-sm">
                            👁 Xem
                        </a>

                        {{-- ✏️ Sửa & 🗑 Xóa (chỉ admin) --}}
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning btn-sm">
                                    ✏ Sửa
                                </a>

                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">🗑 Xóa</button>
                                </form>
                            @endif
                        @endauth
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        🚫 Không có phòng chiếu nào được tìm thấy.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ✅ Phân trang --}}
    <div class="mt-3">
        {{ $rooms->links() }}
    </div>
</div>
@endsection
