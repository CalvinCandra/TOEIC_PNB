{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Peserta')

{{-- membuat content dimana --}}
@section('content')
<main class="p-5 ml-3 md:ml-64 md:px-14 h-auto pt-20">
    <div class="my-6">
        <ol class="relative border-s border-gray-300">

            {{-- Step 1: Hello --}}
            <li class="mb-10 ms-10">
                <span class="absolute flex items-center justify-center w-7 h-7 bg-brand/10 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{ asset('img/PNB.png') }}" alt="PNB" />
                </span>
                <div class="items-center justify-between p-4 bg-white border border-brand/30 rounded-lg shadow-sm sm:flex">
                    <div class="text-base font-normal text-gray-500">
                        Hello <span class="font-semibold text-brand">{{ auth()->user()->name }}</span> 👋
                    </div>
                </div>
            </li>

            {{-- Step 2: Welcome --}}
            <li class="mb-10 ms-10">
                <span class="absolute flex items-center justify-center w-7 h-7 bg-brand/10 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{ asset('img/PNB.png') }}" alt="PNB" />
                </span>
                <div class="items-center justify-between p-4 bg-white border border-brand/30 rounded-lg shadow-sm sm:flex">
                    <div class="text-base font-normal text-gray-500">
                        Welcome to the participant dashboard
                    </div>
                </div>
            </li>

            {{-- Step 3: Complete Data --}}
            <li class="mb-10 ms-10">
                <span class="absolute flex items-center justify-center w-7 h-7 bg-brand/10 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{ asset('img/PNB.png') }}" alt="PNB" />
                </span>
                <div class="items-center justify-between p-4 bg-white border border-brand/30 rounded-lg shadow-sm sm:flex">
                    <div class="text-base font-normal text-gray-500">
                        Before you take the TOEIC test, you must complete your personal data
                        <a href="{{ url('/Profil') }}" class="font-semibold text-brand underline hover:text-brand-hover">Here</a>.
                        Or you can complete your personal data by looking for
                        <span class="font-semibold text-brand">"Profile"</span> in the sidebar
                    </div>
                </div>
            </li>

            {{-- Step 4: Take TOEIC --}}
            <li class="mb-10 ms-10">
                <span class="absolute flex items-center justify-center w-7 h-7 bg-brand/10 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{ asset('img/PNB.png') }}" alt="PNB" />
                </span>
                <div class="items-center justify-between p-4 bg-white border border-brand/30 rounded-lg shadow-sm sm:flex">
                    <div class="text-base font-normal text-gray-500">
                        If you have completed your personal data, now you can take the TOEIC
                    </div>
                </div>
            </li>

            {{-- Step 5: Good Luck --}}
            <li class="mb-10 ms-10">
                <span class="absolute flex items-center justify-center w-7 h-7 bg-brand/10 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{ asset('img/PNB.png') }}" alt="PNB" />
                </span>
                <div class="items-center justify-between p-4 bg-white border border-brand/30 rounded-lg shadow-sm sm:flex">
                    <div class="text-base font-normal text-gray-500">
                        Good Luck 😊
                    </div>
                </div>
            </li>

        </ol>
    </div>
</main>
@endsection
