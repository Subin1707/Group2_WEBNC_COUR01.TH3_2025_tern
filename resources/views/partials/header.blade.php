<!-- 🔝 Top Bar -->
<section id="top">
    <div class="container">
        <div class="row top_1 align-items-center">
            <div class="col-md-3">
                <div class="top_1l pt-1">
                    <h3 class="mb-0">
                        <a class="text-white" href="{{ route('home') }}">
                            <i class="fa fa-video-camera col_red me-1"></i> Q&HCINEMA
                        </a>
                    </h3>
                </div>
            </div>

            <div class="col-md-5">
                <div class="top_1m">
                    <form action="{{ route('movies.index') }}" method="GET" class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="form-control bg-black text-white" placeholder="Tìm phim...">
                        <button class="btn text-white bg_red rounded-0 border-0" type="submit">Tìm</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="top_1r text-end">
                    <ul class="social-network social-circle mb-0">
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🔻 Navbar -->
<section id="header">
    <nav class="navbar navbar-expand-md navbar-dark bg-black" id="navbar_sticky">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">
                <i class="fa fa-video-camera col_red me-1"></i> Q&HCinema
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">

                    {{-- ✅ Đăng nhập rồi --}}
                    @auth
                        @if (Auth::user()->role === 'admin')
                            {{-- 👑 ADMIN --}}
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.movies.index') }}">Phim</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.theaters.index') }}">Rạp</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.rooms.index') }}">Phòng</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.showtimes.index') }}">Lịch chiếu</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.bookings.index') }}">Đặt vé</a></li>

                        @else
                            {{-- 🎟️ KHÁCH HÀNG --}}
                            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Phim</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('showtimes.index') }}">Lịch chiếu</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('theaters.index') }}">Rạp</a></li>
                            {{-- ⚙️ Sửa route name cho đúng --}}
                            <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">Đặt vé</a></li>
                        @endif

                        {{-- 🔒 Đăng xuất --}}
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-white">🚪 Đăng xuất</button>
                            </form>
                        </li>
                    @endauth

                    {{-- ❌ Chưa đăng nhập --}}
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Phim</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Lịch chiếu</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Rạp</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Đăng ký</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</section>
