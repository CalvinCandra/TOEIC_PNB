<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>@yield('Title')</title>
</head>

<body class="font-Poppins">
    @include('layouts.landing.navbar')
    @yield('content')
    @include('layouts.landing.footer')
    @include('layouts.landing.script')
</body>
</html>