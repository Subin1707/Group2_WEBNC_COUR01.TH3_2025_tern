<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Q&HCinema - Rạp Chiếu Phim Online')</title>

    {{-- CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-dark text-white d-flex flex-column min-vh-100">

    {{-- HEADER --}}
    @include('partials.header')

    {{-- CONTENT (KHÔNG BỌC container Ở ĐÂY) --}}
    <main class="flex-fill">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
