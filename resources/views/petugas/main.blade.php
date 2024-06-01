<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>@yield('Title')</title>
</head>

<body style="font-family: 'Poppins'">
    @include('layouts.dashboard.navbar')
    @include('layouts.dashboard.sidebar')
    @yield('content')
    @include('layouts.dashboard.scripts')

    @include('sweetalert::alert')
</body>
</html>