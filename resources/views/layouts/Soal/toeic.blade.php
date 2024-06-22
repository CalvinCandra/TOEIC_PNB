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
                <img src="{{asset('favicon/Logo PNB.png')}}" alt="Logo PNB" class="max-h-10 pe-2">
                <h1 class="font-bold text-xl">TOEIC</h1>
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
        window.addEventListener('popstate', function () {
            history.replaceState(null, null, document.URL);
        });
    </script>

    {{-- Countdown --}}
    <script>
        // Set durasi countdown (60 menit dalam milidetik)
        const countdownDuration = 60 * 60 * 1000;

        // Ambil waktu mulai dari localStorage
        const quizStartTime = parseInt(localStorage.getItem("quizStartTime"));
        const endTime = quizStartTime + countdownDuration;

        // Hentikan countdown sebelumnya (jika ada)
        clearInterval(window.x);

        // Perbarui countdown setiap detik
        window.x = setInterval(function() {
            const currentTime = Date.now();
            const remainingTime = endTime - currentTime;
            const hours = Math.floor(remainingTime / (1000 * 60 * 60));
            const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerHTML = `${hours} h : ${minutes} m : ${seconds} s`;
            if (remainingTime < 0) {
                clearInterval(window.x);
                setTimeout(refreshPage, 100);
            }
        }, 100);

        function refreshPage() {
            window.location.reload(true); // Menggunakan parameter true untuk merefresh dari server
        }
    </script>
</body>
</html>
