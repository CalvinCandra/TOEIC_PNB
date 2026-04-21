<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @include('layouts.header')
    <title>@yield('Title')</title>
</head>

<body class="font-Poppins">
    {{-- Animation Loading --}}
    <div style="display:none;" id="overlay" class="fixed inset-0 bg-slate-900/45 backdrop-blur-[4px] z-[999] flex items-center justify-center">
        <svg class="animate-spin w-10 h-10" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" class="opacity-25"/>
            <path d="M4 12a8 8 0 018-8" stroke="white" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('overlay');
            window.addEventListener('beforeunload', () => { if(overlay) overlay.style.display = 'flex'; });
            window.addEventListener('pageshow', (event) => { if(event.persisted && overlay) overlay.style.display = 'none'; });
        });
    </script>
    @include('layouts.landing.navbar')
    @yield('content')
    @include('layouts.landing.footer')
    @include('layouts.landing.script')
</body>
</html>