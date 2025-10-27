<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laravel App')</title>
</head>
<body>
    <div class="container">
        <h1>@yield('header')</h1>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @yield('content')
    </div>
</body>
</html>
