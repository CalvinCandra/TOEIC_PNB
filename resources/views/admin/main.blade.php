<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layout.header')
    <title>@yield('Title')</title>
</head>

<body style="font-family: 'Poppins','sans-serif';">
    @include('admin.layout.navbar')
    @include('admin.layout.sidebar')
    @yield('content')
    @include('admin.layout.scripts')
</body>
</html>