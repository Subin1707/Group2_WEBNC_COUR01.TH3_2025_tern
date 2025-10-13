<header style="background: #1e293b; padding: 15px; color: #fff;">
    <div style="max-width:1200px; margin:auto; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;">
        <h1 style="font-size:24px; font-weight:bold; color:#facc15; margin-bottom:8px;">
            🎬 Rạp Chiếu Phim Online
        </h1>
        <nav style="display:flex; gap:20px; align-items:center; flex-wrap:wrap;">
            <a href="{{ route('home') }}" style="color:#fff; text-decoration:none;">Trang chủ</a>
            @if(Route::has('client.movies.index'))
                <a href="{{ route('client.movies.index') }}" style="color:#fff; text-decoration:none;">Phim</a>
            @endif
            @if(Route::has('client.showtimes.index'))
                <a href="{{ route('client.showtimes.index') }}" style="color:#fff; text-decoration:none;">Lịch chiếu</a>
            @endif
            @if(Route::has('client.theaters.index'))
                <a href="{{ route('client.theaters.index') }}" style="color:#fff; text-decoration:none;">Rạp</a>
            @endif
            @if(Route::has('client.bookings.index'))
                <a href="{{ route('client.bookings.index') }}" style="color:#fff; text-decoration:none;">Đặt vé</a>
            @endif
            <a href="{{ route('aboutme') }}" style="color:#fff; text-decoration:none;">Giới thiệu</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" style="color:#facc15; text-decoration:none;">Dashboard Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#facc15; cursor:pointer;">
                        Đăng xuất ({{ Auth::user()->name }})
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="color:#facc15; text-decoration:none;">Đăng nhập</a>
            @endauth
        </nav>
    </div>
</header>
