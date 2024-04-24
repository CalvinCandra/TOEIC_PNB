<!DOCTYPE html>
<html lang="en">
<head>
    @include('petugas.layout.header')
    <title>@yield('Title')</title>
</head>

<body style="font-family: 'Poppins','sans-serif';">
    @include('petugas.layout.navbar')
    @include('petugas.layout.sidebar')
    @yield('content')
    @include('petugas.layout.scripts')
</body>
</html>