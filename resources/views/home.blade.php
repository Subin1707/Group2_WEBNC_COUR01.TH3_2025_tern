@extends('layouts.app')

@section('title', 'Trang chủ - Rạp Chiếu Phim Online')

@section('content')
<div class="container mx-auto text-center py-10">
    <h1 class="text-4xl font-bold text-yellow-400 mb-4">🎬 Chào mừng đến với Rạp Chiếu Phim Online!</h1>
    <p class="text-lg text-gray-200 mb-6">
        Trải nghiệm điện ảnh đỉnh cao ngay tại nhà – đặt vé nhanh chóng, xem lịch chiếu, 
        và khám phá những bộ phim hot nhất hôm nay!
    </p>

    <div class="grid md:grid-cols-3 gap-6 mt-8 px-4">
        <div class="p-6 bg-white/10 backdrop-blur rounded-2xl shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-3 text-yellow-300">🍿 Phim Đang Chiếu</h3>
            <p class="text-gray-300">Cập nhật liên tục những bộ phim bom tấn đang hot tại rạp.</p>
            <a href="{{ route('movies.index') }}" class="inline-block mt-4 px-4 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500">Xem ngay</a>
        </div>

        <div class="p-6 bg-white/10 backdrop-blur rounded-2xl shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-3 text-yellow-300">🎟️ Đặt Vé Nhanh</h3>
            <p class="text-gray-300">Chọn rạp, suất chiếu và chỗ ngồi yêu thích chỉ trong vài bước.</p>
            <a href="{{ route('showtimes.index') }}" class="inline-block mt-4 px-4 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500">Đặt vé</a>
        </div>

        <div class="p-6 bg-white/10 backdrop-blur rounded-2xl shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-3 text-yellow-300">⭐ Ưu Đãi Thành Viên</h3>
            <p class="text-gray-300">Nhận ưu đãi và điểm thưởng khi đăng ký tài khoản khách hàng thân thiết.</p>
            <a href="{{ route('register') }}" class="inline-block mt-4 px-4 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500">Tham gia ngay</a>
        </div>
    </div>
</div>
@endsection
