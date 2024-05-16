<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>@yield('Title')</title>
</head>

<body class="font-Poppins">
    @include('layouts.dashboard.navbar')
    @include('layouts.dashboard.sidebar')
    @yield('content')
    @include('layouts.dashboard.scripts')
</body>
</html>