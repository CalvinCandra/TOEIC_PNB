{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Peserta')

{{-- membuat content dimana --}}
@section('content')
<main class="p-5 ml-3 md:ml-64 md:px-8 lg:px-12 h-auto pt-20">
    <div class="my-6 max-w-5xl mx-auto">
        
        {{-- Greeting / Welcome Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 md:p-8 mb-6 text-white shadow-lg relative overflow-hidden mt-2">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2 tracking-tight">Hello, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-blue-100 text-sm md:text-base max-w-xl leading-relaxed">Welcome to the TOEIC Try Out Participant Dashboard. Track your progress and jump right into your next simulation.</p>
                </div>
            </div>
            {{-- Decorative elements --}}
            <div class="absolute -right-10 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute right-32 -bottom-20 w-48 h-48 bg-blue-400/20 rounded-full blur-2xl"></div>
            <img src="{{ asset('img/PNB.png') }}" alt="PNB" class="absolute right-4 -bottom-4 w-32 h-32 opacity-15 drop-shadow-xl grayscale">
        </div>

        {{-- Steps Section --}}
        <div>
            <h2 class="text-lg font-bold text-gray-900 mb-4 px-1">Your Next Steps</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                {{-- Step 1 --}}
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group flex flex-col">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 text-lg font-bold group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        1
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1.5">Change Password</h3>
                    <p class="text-xs text-gray-500 leading-relaxed mb-5">Security first. Please change your default password so you can proceed to the Try Out securely.</p>
                    <a href="{{ url('/reset-password') }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto">
                        Update Password <i class="fa-solid fa-arrow-right ml-1.5"></i>
                    </a>
                </div>

                {{-- Step 2 --}}
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group flex flex-col">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 text-lg font-bold group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        2
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1.5">Complete Profile</h3>
                    <p class="text-xs text-gray-500 leading-relaxed mb-5">Ensure your personal data is accurate. This will be printed on your simulation score report.</p>
                    <a href="{{ url('/Profil') }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors mt-auto">
                        Update Profile <i class="fa-solid fa-arrow-right ml-1.5"></i>
                    </a>
                </div>

                {{-- Step 3 --}}
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group flex flex-col">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 text-lg font-bold group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        3
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1.5">Take Try Out Test</h3>
                    <p class="text-xs text-gray-500 leading-relaxed mb-5">Enter your test code and begin the TOEIC simulation assessment.</p>
                    <a href="{{ url('/DashboardSoal') }}" class="inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-800 transition-colors mt-auto">
                        Go to Try Out <i class="fa-solid fa-arrow-right ml-1.5"></i>
                    </a>
                </div>

            </div>
        </div>

    </div>
</main>
@endsection
