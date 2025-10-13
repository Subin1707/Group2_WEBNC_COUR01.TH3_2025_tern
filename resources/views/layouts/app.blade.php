<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> @yield('title', 'Laravel News')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    @include('partials.header')
    <div class="container">
        @yield('content') 
    </div>
   @include('partials.footer')
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
