<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        window.history.forward(1);
    </script>
</head>

<body class="min-h-screen flex flex-col bg-[#E0E0E0]">
    <header class="bg-white py-4 shadow w-full">
        <nav class="flex items-center justify-between px-10">
            <div class="flex justify-between items-center">
                <img src="{{ asset('img/PNB.png') }}" alt="" class="h-10">
                <div class="flex flex-col items-center ml-2">
                    <span class="block text-sm font-bold whitespace-nowrap dark:text-white flex-grow flex-basis-0">TOEIC
                        ASSESSMENT</span>
                    <span class="block text-sm text-gray-500 flex-grow flex-basis-0">Politeknik Negeri Bali</span>
                </div>
            </div>
            <div class="flex items-center">
                @yield('timer')
            </div>
        </nav>
    </header>
    <div class="flex flex-1 px-3 py-4">
        <aside class="bg-white p-4 w-1/4 mr-1 rounded overflow-y-auto justify-center hidden sm:block">
            <!-- Sidebar content -->
            @yield('sidebar')
        </aside>
        <main class="flex-1 bg-white p-4 ml-1 rounded">
            <!-- Main content goes here -->
            @yield('content')
        </main>
    </div>


    {{-- matiin fungsi back pada browser --}}
    <script>
        history.replaceState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.replaceState(null, null, document.URL);
        });
    </script>

</body>

</html>
