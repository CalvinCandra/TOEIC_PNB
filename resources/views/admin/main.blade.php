<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>@yield('Title')</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>

<body style="font-family: 'Poppins'">
    {{-- Animation Loading container removed to speed up perceptual navigation --}}
    @include('layouts.dashboard.navbar')
    @include('layouts.dashboard.sidebar')
    @yield('content')
    @include('layouts.dashboard.scripts')

    @include('sweetalert::alert')

</body>
</html>