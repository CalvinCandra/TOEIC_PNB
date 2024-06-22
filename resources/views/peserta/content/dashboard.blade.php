{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Peserta')

{{-- membuat content disini --}}
@section('content')

<main class="p-5 ml-3 md:ml-64 md:px-14 h-auto pt-20">

    <div class="my-6"> 
        <ol class="relative border-s border-black">
            <li class="mb-10 ms-10">
                <span class="absolute flex items-center justify-center w-7 h-7 bg-blue-100 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{asset('favicon/Logo PNB.png')}}" alt="Bonnie image"/>
                </span>
                <div class="items-center justify-between p-4 bg-white border border-sky-300 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                    <div class="text-md font-normal text-gray-500 dark:text-gray-300">Hello <span class="font-semibold text-blue-600">{{auth()->user()->name}}</span> 👋</div>
                </div>
            </li>
            <li class="mb-10 ms-10">            
                <span class="absolute flex items-center justify-center w-7 h-7 bg-blue-100 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{asset('favicon/Logo PNB.png')}}" alt="Bonnie image"/>
                </span>
                <div class="items-center justify-between p-4 bg-white border border-sky-300 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                    <div class="text-md font-normal text-gray-500 dark:text-gray-300">Welcome to the participant dashboard</div>
                </div>
            </li>
            <li class="mb-10 ms-10">
                <span class="absolute flex items-center justify-center w-7 h-7 bg-blue-100 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{asset('favicon/Logo PNB.png')}}" alt="Jese Leos image"/>
                </span>
                <div class="items-center justify-between p-4 bg-white border border-sky-300 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                    <div class="text-md font-normal text-gray-500 lex dark:text-gray-300">Before you take the TOEIC test, you must complete your personal data <a href="{{url('/Profil')}}" class="font-semibold text-blue-600 underline hover:text-blue-800">Here</a>. Or you can complete your personal data by looking for <span class="font-semibold text-blue-600">"Profile"</span> in the sidebar</div>
                </div>
            </li>
            <li class="mb-10 ms-10">            
                <span class="absolute flex items-center justify-center w-7 h-7 bg-blue-100 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{asset('favicon/Logo PNB.png')}}" alt="Bonnie image"/>
                </span>
                <div class="items-center justify-between p-4 bg-white border border-sky-300 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                    <div class="text-md font-normal text-gray-500 dark:text-gray-300">If you have completed your personal data, now you can take the TOEIC</div>
                </div>
            </li>
            <li class="mb-10 ms-10">            
                <span class="absolute flex items-center justify-center w-7 h-7 bg-blue-100 rounded-full -start-3 ring-8 ring-white -left-[14.5px]">
                    <img class="rounded-full shadow-lg" src="{{asset('favicon/Logo PNB.png')}}" alt="Bonnie image"/>
                </span>
                <div class="items-center justify-between p-4 bg-white border border-sky-300 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                    <div class="text-md font-normal text-gray-500 dark:text-gray-300">Good Luck 😊</div>
                </div>
            </li>
        </ol>
    </div>

  </main>
@endsection