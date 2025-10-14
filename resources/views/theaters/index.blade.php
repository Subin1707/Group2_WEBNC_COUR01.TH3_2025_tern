@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🎭 Danh sách rạp chiếu</h1>

    {{-- Hiển thị nút thêm chỉ khi là admin --}}
    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.theaters.create') }}" class="btn btn-primary mb-3">➕ Thêm rạp mới</a>
        @endif
    @endauth

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên rạp</th>
                <th>Địa chỉ</th>
                <th>Tổng số phòng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($theaters as $theater)
                <tr>
                    <td>{{ $theater->name }}</td>
                    <td>{{ $theater->address }}</td>
                    <td>{{ $theater->total_rooms }}</td>
                    <td>
                        <a href="{{ route('theaters.show', $theater) }}" class="btn btn-info btn-sm">👁️</a>

                        {{-- Chỉ admin mới thấy nút sửa / xóa --}}
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('admin.theaters.edit', $theater) }}" class="btn btn-warning btn-sm">✏️</a>
                            <form action="{{ route('admin.theaters.destroy', $theater) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa rạp này?')">🗑️</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Chưa có rạp nào</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
