<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>@yield('title')</title>
</head>
<body class="min-h-screen flex flex-col bg-[#E0E0E0]">
    <header class="bg-white py-4 shadow w-full">
        <nav class="flex items-center justify-between px-10">
            <div class="flex justify-between items-center">
                <img src="{{asset('favicon/Logo PNB.png')}}" alt="Logo PNB" class="max-h-10 pe-2">
                <h1 class="font-bold text-xl">TOEIC</h1>
            </div>
            <div class="flex items-center">
                @yield('timer')
            </div>
        </nav>
    </header>
    <div class="flex flex-1 px-3 py-4">
        <aside class="bg-white p-4 w-1/4 mr-1 rounded overflow-y-auto justify-center">
            <!-- Sidebar content -->
            @yield('sidebar')
        </aside>
        <main class="flex-1 bg-white p-4 ml-1 rounded">
            <!-- Main content goes here -->
            @yield('content')
        </main>
    </div>
</body>
</html>
