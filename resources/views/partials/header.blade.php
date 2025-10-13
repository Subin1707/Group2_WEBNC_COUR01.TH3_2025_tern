<header style="background: #f5f5f5; padding: 10px;">
    <h1>Laravel News</h1>
    <nav>
        <a href="{{ route('home') }}">Trang chủ</a> |
        <a href="{{ route('news.index') }}">Tin tức</a> |
        <a href="{{ route('aboutme') }}">Giới thiệu</a> |

        @auth
            <!-- Nếu đã đăng nhập -->
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:blue;cursor:pointer;">
                    Đăng xuất ({{ Auth::user()->name }})
                </button>
            </form>
        @else
            <!-- Nếu chưa đăng nhập -->
            <a href="{{ route('login') }}" style="color:blue;">Đăng nhập</a>
        @endauth
    </nav>
</header>
