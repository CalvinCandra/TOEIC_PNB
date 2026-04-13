{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman dimana --}}
@section('Title', 'Tryout')

{{-- membuat content dimana --}}
@section('content')

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<main class="p-5 ml-3 md:ml-64 md:px-14 h-auto pt-20">

    {{-- Grid 2 card --}}
    <div class="flex flex-col gap-5">

        {{-- ── Card 1: TOEIC Simulation (existing) ── --}}
        <a data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
            class="relative flex flex-col md:flex-row items-stretch bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-brand/30 dark:border-gray-700 dark:bg-gray-800 group transition-all duration-300 cursor-pointer">

            <img class="object-cover w-full md:w-48 rounded-t-xl md:rounded-t-none md:rounded-l-xl"
                src="{{ asset('img/English.png') }}" alt="English Image" />

            <div class="flex flex-col justify-between p-5 pl-9 leading-normal flex-1">
                <div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">TOEIC Simulation</h5>
                    <p class="font-normal text-gray-600 text-base leading-relaxed">
                        A test specifically designed to prepare and enhance English language skills for the TOEIC exam.
                        <br><br>
                        You will spend approximately 120 minutes (2 hours) for this test. There will be a countdown timer:
                        <br>
                        45 minutes for Listening Test
                        <br>
                        75 minutes for Reading Test
                        <br><br>
                        Use your time wisely, otherwise your answers will be submitted automatically once the time is over.
                    </p>
                </div>
            </div>

            {{-- Tombol panah --}}
            <button class="absolute bottom-4 right-4 p-2 border border-slate-400 text-slate-500 rounded-full group-hover:border-transparent group-hover:bg-brand group-hover:text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </a>

        {{-- ── Card 2: Manual Test — Coming Soon ── --}}
        <div class="relative flex flex-col md:flex-row items-stretch bg-gray-50 border border-gray-200 rounded-xl shadow-sm opacity-70 cursor-not-allowed overflow-hidden">

            {{-- Label Coming Soon --}}
            <div class="absolute top-4 right-4 z-10">
                <span class="bg-brand text-white text-xs font-semibold px-3 py-1 rounded-full tracking-wide uppercase">
                    Coming Soon
                </span>
            </div>

            {{-- Placeholder gambar --}}
            <div class="w-full md:w-48 bg-brand/10 rounded-t-xl md:rounded-t-none md:rounded-l-xl flex items-center justify-center min-h-[140px]">
                <svg class="w-16 h-16 text-brand/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
                </svg>
            </div>

            <div class="flex flex-col justify-between p-5 pl-9 leading-normal flex-1">
                <div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-400">Manual Test</h5>
                    <p class="font-normal text-gray-400 text-base leading-relaxed">
                        Take the TOEIC test at your own pace without a countdown timer.
                        Answer questions freely and review them before submitting your final answers.
                        <br><br>
                        This feature is currently under development and will be available soon.
                    </p>
                </div>
            </div>

        </div>

    </div>

</main>

{{-- Modal input kode soal --}}
<div id="authentication-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-xl shadow">

            {{-- Modal header --}}
            <div class="flex items-center justify-between p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">Enter Test Code</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="p-5">
                <form class="space-y-4" action="{{ url('/TokenQuestion') }}">
                    <div>
                        <label for="token" class="block mb-2 text-sm font-medium text-gray-900">Test Code</label>
                        <input type="text" name="bankSoal" id="token"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5"
                            placeholder="Input your test code" required />
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-brand hover:bg-brand-hover focus:ring-4 focus:outline-none focus:ring-brand/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                        Let's Start
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Disable back button --}}
<script>
    history.replaceState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.replaceState(null, null, document.URL);
    });
</script>

@endsection
