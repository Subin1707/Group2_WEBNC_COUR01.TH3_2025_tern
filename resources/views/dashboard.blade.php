@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container mx-auto py-10 text-gray-200">

    {{-- HEADER --}}
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-yellow-400 mb-2">📊 Bảng điều khiển</h1>
        <p class="text-gray-300">
            Chào mừng, <span class="font-semibold">{{ $user->name }}</span>!
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

        {{-- THÔNG TIN NGƯỜI DÙNG --}}
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">Thông tin người dùng</h2>
            <p>Email: {{ $user->email }}</p>
            <p>
                Vai trò: {{ $user->roleLabel() }}
            </p>
        </div>

        {{-- ================= KHÁCH HÀNG ================= --}}
        @if(!in_array($user->role, ['admin', 'staff']))
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">Chức năng khách hàng</h2>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('showtimes.index') }}" class="text-green-400 hover:underline">
                        ⏰ Xem lịch chiếu
                    </a>
                </li>
                <li>
                    <a href="{{ route('bookings.index') }}" class="text-green-400 hover:underline">
                        🎟️ Xem đặt vé
                    </a>
                </li>
                <li>
                    <a href="{{ route('bookings.choose') }}" class="text-green-400 hover:underline">
                        🛒 Đặt vé mới
                    </a>
                </li>
            </ul>
        </div>
        @endif

        {{-- ================= NHÂN VIÊN ================= --}}
{{-- ================= NHÂN VIÊN ================= --}}
    @if($user->role === 'staff')
    <div class="bg-white/10 p-6 rounded-2xl shadow-md">
        <h2 class="text-xl font-semibold mb-2">Chức năng nhân viên</h2>
        <ul class="space-y-1">
            <li>
                <a href="{{ route('staff.showtimes.index') }}" class="text-blue-400 hover:underline">
                    🎬 Quản lý lịch chiếu
                </a>
            </li>
            <li>
                <a href="{{ route('staff.bookings.index') }}" class="text-blue-400 hover:underline">
                    🎟️ Kiểm tra vé
                </a>
            </li>
        </ul>
    </div>
    @endif

    </div>

    {{-- ================= ADMIN DASHBOARD ================= --}}
    @if($user->role === 'admin')
    <section id="spec">
        <div class="container-xl">
            <div class="row text-center text-white">

                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-users"></i></span>
                        <h2>{{ $userCount }}</h2>
                        <h6>
                            <a href="{{ route('theaters.index') }}" class="text-white text-decoration-none">
                                Người dùng
                            </a>
                        </h6>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-film"></i></span>
                        <h2>{{ $movieCount }}</h2>
                        <h6>
                            <a href="{{ route('movies.index') }}" class="text-white text-decoration-none">
                                Phim hiện có
                            </a>
                        </h6>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-money"></i></span>
                        <h2>{{ number_format($revenue, 0, ',', '.') }}₫</h2>
                        <h6>
                            <a href="{{ route('dashboard.revenue') }}" class="text-white text-decoration-none">
                                Tổng doanh thu
                            </a>
                        </h6>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="spec_1i p-4 bg-white/10 rounded">
                        <span class="font_60 col_red"><i class="fa fa-ticket"></i></span>
                        <h2>{{ $ticketCount }}</h2>
                        <h6>
                            <a href="{{ route('bookings.index') }}" class="text-white text-decoration-none">
                                Vé đã bán
                            </a>
                        </h6>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    <div class="mt-10 text-center">
        <p class="text-gray-400">Bạn đã đăng nhập thành công 🎉</p>
    </div>

</div>
@endsection
