@extends('layouts.app')

@section('title', 'Trang chủ - Rạp Chiếu Phim Online')

@section('content')

<section id="home_intro" class="pt-4 pb-5 bg_grey" style="background-color: #0b0b0b;">
    <div class="container text-light">
        {{-- Tiêu đề chính --}}
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <div class="trend_11">
                    <h4 class="mb-3">
                        <i class="fa fa-film align-middle col_red me-2"></i>
                        <span class="text-white">Chào mừng đến với</span> 
                        <span class="col_red">Rạp Chiếu Phim Online</span>
                    </h4>
                    <p class="text-secondary fs-5">
                        Trải nghiệm điện ảnh đỉnh cao ngay tại nhà – đặt vé nhanh chóng, xem lịch chiếu, 
                        và khám phá những bộ phim hot nhất hôm nay!
                    </p>
                </div>
            </div>
        </div>

        {{-- 3 khối chính --}}
        <div class="row text-center popular_1 mt-4">
            {{-- Phim đang chiếu --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-black rounded-4 border border-danger shadow-lg h-100 hover-shadow">
                    <h3 class="text-danger mb-3">
                        🍿 Phim Đang Chiếu
                    </h3>
                    <p class="text-secondary">
                        Cập nhật liên tục những bộ phim bom tấn đang hot tại rạp.
                    </p>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.movies.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                                Quản lý phim
                            </a>
                        @else
                            <a href="{{ route('movies.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                                Xem ngay
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                           Xem ngay
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Đặt vé nhanh --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-black rounded-4 border border-danger shadow-lg h-100 hover-shadow">
                    <h3 class="text-danger mb-3">
                        🎟️ Đặt Vé Nhanh
                    </h3>
                    <p class="text-secondary">
                        Chọn rạp, suất chiếu và chỗ ngồi yêu thích chỉ trong vài bước.
                    </p>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                               Quản lý đặt vé
                            </a>
                        @else
                            <a href="{{ route('showtimes.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                               Đặt vé
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                           Đặt vé
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Ưu đãi thành viên --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-black rounded-4 border border-danger shadow-lg h-100 hover-shadow">
                    <h3 class="text-danger mb-3">
                        ⭐ Ưu Đãi Thành Viên
                    </h3>
                    <p class="text-secondary">
                        Nhận ưu đãi và điểm thưởng khi đăng ký tài khoản khách hàng thân thiết.
                    </p>

                    @auth
                        <span class="btn btn-secondary rounded-pill fw-semibold mt-3 px-4 py-2">
                            Bạn đã là thành viên
                        </span>
                    @else
                        <a href="{{ route('register') }}" 
                           class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                           Tham gia ngay
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<section id="popular" class="pt-4 pb-5 bg_grey">
    <div class="container">
        <div class="row trend_1">
            <div class="col-md-12">
                <div class="trend_11">
                    <h4 class="mb-0"><i class="fa fa-youtube-play align-middle col_red me-1"></i>Trending <span class="col_red">Movies</span></h4>

                </div>
            </div>
        </div> 
    </div>
    <div class="row popular_1 mt-4">
        <ul class="nav nav-tabs border-0 mb-0">
            <li class="nav-item">
                <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                    <span class="d-md-block">JUST ARRIVED</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#profile" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                    <span class="d-md-block">POPULAR EVENTS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                    <span class="d-md-block">TV SHOWS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#setting_o" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                    <span class="d-md-block">FREE MOVIES</span>
                </a>
            </li>
        </ul>
    </div>

</section>

@endsection
