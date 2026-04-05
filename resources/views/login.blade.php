<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>Login</title>
</head>

<body class="font-['Poppins'] bg-slate-100 m-0">

    {{-- Loading Overlay --}}
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 items-center justify-center z-[999] hidden" id="overlay">
        <div class="text-center">
            <div role="status">
                <svg aria-hidden="true"
                    class="inline w-10 h-10 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="flex w-full max-w-4xl min-h-[520px] bg-white rounded-2xl overflow-hidden shadow-lg">

            {{-- Panel Kiri — Logo --}}
            <div class="hidden lg:flex flex-1 flex-col items-center justify-center gap-6 p-10 bg-blue-950">

                <img src="{{ asset('auth/login.png') }}" alt="Logo PNB" class="w-56 object-contain" />

                <div class="text-center">
                    <p class="text-xl font-semibold text-white tracking-widest">POLITEKNIK NEGERI BALI</p>
                    <p class="text-base font-semibold text-white mt-1">Unit Penunjang Akademik Bahasa</p>
                </div>

            </div>

            {{-- Panel Kanan — Form --}}
            <div class="flex-1 flex flex-col justify-center px-10 py-12">

                <h1 class="text-3xl font-medium text-center uppercase tracking-widest text-slate-900 mb-2">
                    Login
                </h1>
                <p class="text-base text-slate-500 mb-7">Enter your email to log in.</p>

                {{-- Error Alert --}}
                @if (count($errors) > 0)
                    <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-4">
                        @foreach ($errors->all() as $error)
                            <p class="text-base text-red-600 italic m-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ url('/ProsesLogin') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}"
                        class="w-full h-12 px-5 rounded-full border border-slate-200 bg-white text-slate-900 text-base italic outline-none focus:border-blue-950 focus:ring-2 focus:ring-blue-950/20 font-[inherit]" />

                    {{-- Password --}}
                    <div class="relative">
                        <input type="password" name="password" id="inputPassword" placeholder="Your Password"
                            class="w-full h-12 pl-5 pr-14 rounded-full border border-slate-200 bg-white text-slate-900 text-base italic outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 font-[inherit]" />
                        <span onclick="togglePassword()"
                            class="absolute right-5 top-1/2 -translate-y-1/2 cursor-pointer text-slate-400 flex items-center">
                            <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </span>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full h-12 rounded-full bg-blue-950 hover:bg-blue-900 text-white text-base font-normal tracking-wide transition-colors duration-150 font-[inherit]">
                        Continue
                    </button>
                </form>

                <p class="text-base text-slate-400 text-center mt-6 leading-relaxed">
                    By continuing, you agree to the updated
                    <strong class="text-slate-500 font-medium">Terms of Sale, Terms of Service</strong>,
                    and <strong class="text-slate-500 font-medium">Privacy Policy.</strong>
                </p>

            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('overlay');
            window.addEventListener('beforeunload', function() {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            });
            window.addEventListener('load', function() {
                overlay.classList.remove('flex');
                overlay.classList.add('hidden');
            });
        });

        function togglePassword() {
            const pw = document.getElementById('inputPassword');
            const ico = document.getElementById('eyeIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                ico.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            } else {
                pw.type = 'password';
                ico.innerHTML =
                    '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            }
        }
    </script>

</body>

</html>
