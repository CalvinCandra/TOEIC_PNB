{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Question')

{{-- membuat content disini --}}
@section('content')

    <main class="p-5 ml-3 md:ml-64 md:px-14 h-auto pt-20">

        {{-- <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="text-left block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
    <h5 class="mb-2 text-2xl font-bold tracking-tight">TOEIC</h5>
    <p class="font-normal text-gray-700">TOEIC is a popular English quiz, because this quiz certificate can be used in various places.</p>
  </button> --}}
        <a data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
            class="relative flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 group">
            <img class="object-cover w-full rounded-t-lg h- md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                src="{{ asset('img/English.png') }}" alt="">
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">TOEIC SIMULATION</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">A test specifically designed to prepare and
                    enhance English language skills for the TOEIC exam.</p>
                <button
                    class="absolute bottom-4 right-4 p-2 border border-slate-600 text-slate-600 rounded-full group-hover:border-hidden group-hover:bg-[#219EBC] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </a>

    </main>


    <!-- Main modal -->
    <div id="authentication-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Question
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ url('/TokenQuestion') }}">
                        <div>
                            <label for="token" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Token
                                Question</label>
                            <input type="token" name="bankSoal" id="token"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Input your token question" required />
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Let's
                            Start</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- matiin fungsi back browser --}}
    <script>
        history.replaceState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.replaceState(null, null, document.URL);
        });
    </script>

    {{-- <script>
        // Matikan tombol back di browser
        history.pushState(null, null, window.location.href);
        window.onpopstate = function(event) {
            history.go(1); // Kembali ke halaman saat ini jika tombol back ditekan
        };
    </script> --}}

@endsection
