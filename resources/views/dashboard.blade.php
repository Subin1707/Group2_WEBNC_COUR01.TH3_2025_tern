@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container mx-auto py-10 text-gray-200">

    <!-- Tiêu đề -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-yellow-400 mb-2">📊 Bảng điều khiển</h1>
        <p class="text-gray-300">Chào mừng, <span class="font-semibold">{{ $user->name }}</span>!</p>
    </div>

    <!-- Thông tin người dùng -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">Thông tin người dùng</h2>
            <p>Email: {{ $user->email }}</p>
            <p>Vai trò: {{ $user->role === 'admin' ? 'Admin' : 'Khách hàng' }}</p>
        </div>

        @unless($user->role === 'admin')
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">Chức năng khách hàng</h2>
            <ul class="space-y-1">
                <li><a href="{{ route('showtimes.index') }}" class="text-green-400 hover:underline">⏰ Xem lịch chiếu</a></li>
                <li><a href="{{ route('bookings.index') }}" class="text-green-400 hover:underline">🎟️ Xem đặt vé</a></li>
                <li><a href="{{ route('bookings.choose') }}" class="text-green-400 hover:underline">🛒 Đặt vé mới</a></li>
            </ul>
        </div>
        @endunless
    </div>

    <!-- 🔥 Thống kê cho Admin -->
    @if($user->role === 'admin')
    <section id="spec" >
        <div class="container-xl">
            <div class="row text-center text-white">
                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-users"></i></span>
                        <h2>{{ $userCount }}</h2>
                        <h6><a href="{{ route('theaters.index') }}" class="text-white text-decoration-none"><i class="fa fa-users me-2"></i>Người Dùng</a></h6>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-film"></i></span>
                        <h2>{{ $movieCount }}</h2>
                        <h6><a href="{{ route('movies.index') }}" class="text-white text-decoration-none"><i class="fa fa-film me-2"></i>Phim Hiện Có</a></h6>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-money"></i></span>
                        <h2>{{ number_format($revenue, 0, ',', '.') }}₫</h2>
                        <h6><a href="{{ route('dashboard.revenue') }}" class="text-white text-decoration-none"><i class="fa fa-chart-line me-2"></i>Tổng Doanh Thu</a></h6>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-ticket"></i></span>
                        <h2>{{ $ticketCount }}</h2>
                        <h6><a href="{{ route('bookings.index') }}" class="text-white text-decoration-none"><i class="fa fa-ticket me-2"></i>Vé Đã Bán</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Lời chào -->
    <div class="mt-10 text-center">
        <p class="text-gray-400">Bạn đã đăng nhập thành công 🎉</p>
    </div>
</div>
@endsection
