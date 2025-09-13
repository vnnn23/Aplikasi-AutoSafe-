<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AutoSafe')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
