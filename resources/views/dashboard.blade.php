@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container mx-auto py-10">
    <!-- Tiêu đề -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-yellow-400 mb-2">📊 Bảng điều khiển</h1>
        <p class="text-gray-300">Chào mừng, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>
    </div>

    <!-- Khung thông tin -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Thẻ thông tin chung -->
        <div class="bg-white/10 p-6 rounded-2xl text-gray-200 shadow-md">
            <h2 class="text-xl font-semibold mb-2">Thông tin người dùng</h2>
            <p>Email: {{ Auth::user()->email }}</p>
        </div>

        <!-- Thẻ Admin chỉ hiển thị nếu là Admin -->
        @if(Auth::user()->is_admin)
        <div class="bg-white/10 p-6 rounded-2xl text-gray-200 shadow-md">
            <h2 class="text-xl font-semibold mb-2">Quản lý hệ thống</h2>
            <ul class="space-y-1">
                <li><a href="{{ route('admin.movies.index') }}" class="text-blue-400 hover:underline">🎬 Quản lý phim</a></li>
                <li><a href="{{ route('admin.rooms.index') }}" class="text-blue-400 hover:underline">🏟 Quản lý phòng chiếu</a></li>
                <li><a href="{{ route('admin.showtimes.index') }}" class="text-blue-400 hover:underline">⏰ Quản lý suất chiếu</a></li>
                <li><a href="{{ route('admin.bookings.index') }}" class="text-blue-400 hover:underline">🧾 Quản lý đặt vé</a></li>
            </ul>
        </div>
        @endif

    </div>

    <!-- Lời chào cuối -->
    <div class="mt-10 text-center">
        <p class="text-gray-400">Bạn đã đăng nhập thành công 🎉</p>
    </div>
</div>
@endsection
