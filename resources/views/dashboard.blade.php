@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')

<div class="container mx-auto py-10 text-gray-200">

    {{-- HEADER --}}
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-yellow-400 mb-2">
            👤 Thông tin người dùng
        </h1>
        <p class="text-gray-300">
            Chào mừng, <span class="font-semibold">{{ $user->name }}</span>!
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

        {{-- THÔNG TIN NGƯỜI DÙNG --}}
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">📄 Hồ sơ</h2>
            <p>Email: <strong>{{ $user->email }}</strong></p>
            <p>Vai trò: <strong>{{ $user->roleLabel() }}</strong></p>
        </div>

        {{-- ================= KHÁCH HÀNG ================= --}}
        @if(!in_array($user->role, ['admin', 'staff']))
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">🎫 Chức năng khách hàng</h2>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('showtimes.index') }}" class="text-green-400 hover:underline">
                        ⏰ Xem lịch chiếu
                    </a>
                </li>
                <li>
                    <a href="{{ route('bookings.history') }}" class="text-green-400 hover:underline">
                        🎟️ Vé của tôi
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
        @if($user->role === 'staff')
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">🧾 Chức năng nhân viên</h2>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('staff.bookings.index') }}" class="text-blue-400 hover:underline">
                        🎟️ Quản lý / kiểm tra vé
                    </a>
                </li>
            </ul>
        </div>
        @endif

    </div>

    {{-- ================= ADMIN ================= --}}
    @if($user->role === 'admin')
    <section id="spec" class="mt-10">
        <div class="container-xl">
            <div class="row text-center text-white">

                <div class="col-md-3 col-6 mb-4">
                    <div class="p-4 bg-white/10 rounded">
                        <i class="fa fa-users fa-2x col_red mb-2"></i>
                        <h2>{{ $userCount }}</h2>
                        <p>Người dùng</p>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="p-4 bg-white/10 rounded">
                        <i class="fa fa-film fa-2x col_red mb-2"></i>
                        <h2>{{ $movieCount }}</h2>
                        <p>Phim</p>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="p-4 bg-white/10 rounded">
                        <i class="fa fa-money fa-2x col_red mb-2"></i>
                        <h2>{{ number_format($revenue, 0, ',', '.') }}₫</h2>
                        <p>Doanh thu</p>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-4">
                    <div class="p-4 bg-white/10 rounded">
                        <i class="fa fa-ticket fa-2x col_red mb-2"></i>
                        <h2>{{ $ticketCount }}</h2>
                        <p>Vé đã bán</p>
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
