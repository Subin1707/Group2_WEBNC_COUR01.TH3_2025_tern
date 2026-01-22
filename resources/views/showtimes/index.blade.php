@extends('layouts.app')

@section('content')
<div class="container">

    {{-- TIÊU ĐỀ --}}
    <div class="row trend_1 mb-3">
        <div class="col-md-6 col-6">
            <h4 class="mb-0">
                <i class="fa fa-clock-o col_red me-1"></i>
                Lịch <span class="col_red">Suất chiếu trong tuần</span>
            </h4>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="col-md-5 mb-3">
        <form action="{{ route('showtimes.index') }}" method="GET" class="input-group">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control bg-black text-white"
                   placeholder="Tìm phim / phòng / ngày...">
            <button class="btn bg_red text-white">Tìm</button>
        </form>
    </div>

    {{-- ADMIN --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary mb-3">
            ➕ Thêm suất chiếu
        </a>
    @endif

    {{-- GROUP SUẤT CHIẾU THEO NGÀY --}}
    @php
        $grouped = $showtimes->groupBy(fn($s) => \Carbon\Carbon::parse($s->start_time)->toDateString());
    @endphp

    @forelse ($grouped as $date => $items)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white">
                📅 {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d/m/Y') }}
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Phim</th>
                            <th>Phòng</th>
                            <th>Giờ chiếu</th>
                            <th>Giá vé</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $showtime)
                            <tr>
                                <td>{{ $showtime->movie->title ?? 'N/A' }}</td>
                                <td>{{ $showtime->room->name ?? 'N/A' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                </td>
                                <td>{{ number_format($showtime->price, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.showtimes.show', $showtime) }}"
                                           class="btn btn-info btn-sm">👁</a>

                                        <a href="{{ route('admin.showtimes.edit', $showtime) }}"
                                           class="btn btn-warning btn-sm">✏️</a>

                                        <form action="{{ route('admin.showtimes.destroy', $showtime) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Xóa suất chiếu này?')">🗑</button>
                                        </form>
                                    @else
                                        <a href="{{ route('showtimes.show', $showtime) }}"
                                           class="btn btn-info btn-sm">👁 Xem</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-secondary text-center">
            Không có suất chiếu trong tuần này.
        </div>
    @endforelse

    {{-- PAGINATION --}}
    {{ $showtimes->appends(request()->query())->links() }}

</div>
@endsection
