@extends('layouts.Soal.toeic')

@section('title')
    TOEIC Test
@endsection

@section('timer')
    <div class="mr-3 text-blue-500">
        Reading
    </div>

    <span id="countdown-nav" class="bg-[#023047] p-2 rounded-lg text-white">Timer</span>
@endsection

@section('sidebar')
    <h1 class="text-center text-5xl font-bold px-5 mb-9 text-blue-500">
        Reading
    </h1>

    <div class="flex justify-center">
        <span id="countdown-sid" class="bg-[#023047] p-2 rounded-lg text-white text-4xl">Timer</span>
    </div>
@endsection

{{-- @dd(session('waktu_akhir')) --}}

@section('content')

    <form action="{{url('/ProsesJawabReading')}}" method="post" id="toeic_form">
        @csrf
        <!-- Save id part -->
        <div class="">
            <input type="hidden" name="id_part" value="{{ $part->id_part}}">
        </div>

        <!-- Part disini (include gambar/audio) -->
        <div class="border rounded-xl relative z-30 text-justify block" id="petunjuk">
            {{-- judul --}}
            <h1 class="text-xl font-bold mb-5 bg-[#D7E1FB] p-3 rounded-t-lg border-b">
                {{$part->part}} Reading - Question <span id="currentQuestion">{{$part->dari_nomor}} to {{$part->sampai_nomor}}</span>
            </h1>

            {{-- petunjuk --}}
            <div class="px-2 pb-2">
                <p class="">{!! $part->petunjuk !!}</p>
            </div>

            {{-- gambar atau audio --}}
            <div class="mx-2 mb-2">
                @if (!empty($part->id_gambar))
                    <img src="{{asset('storage/gambar/'.$part->gambar->gambar)}}" alt="gambar soal" class="max-h-96 pb-2 mt-3">
                @endif
            </div>
        </div>

        {{-- Multi Question --}}
        @if (!$part->multi_soal == NULL)
            <div class="border-2 relative z-30 text-justify block mt-5" id="multi">
                {{-- judul --}}
                <h1 class="text-md font-bold mb-5 p-3 border-b">
                    Multiple Question Number <span id="currentQuestion">{{$part->dari_nomor}} to {{$part->sampai_nomor}}</span>
                </h1>

                {{-- multiSoal --}}
                <div class="px-2 pb-2">
                    <p class="">{!! $part->multi_soal !!}</p>
                </div>
            </div>
        @endif

        <div class="block" id="soal">
            @foreach ($soalReading as $data)
                <div class="border rounded-lg relative z-30 text-justify mt-10 mb-5">
                    <!-- Save id soal -->
                    <div class="">
                        <input type="hidden" name="id_soal[]" value="{{ $data->id_soal }}">
                    </div>

                    {{-- judul --}}
                    <h1 class="text-md font-bold mb-5 bg-[#F3F3F3] p-3 rounded-t-lg border-b">
                        Reading - Question <span id="currentQuestion">{{$data->nomor_soal}}</span>
                    </h1>

                    {{-- gambar atau audio --}}
                    <div class="mx-4">
                        @if (!empty($data->id_audio))
                            @if (!$audioPlayed)
                            <audio id="audio" controls>
                                <source src="{{asset('storage/audio/'.$data->audio->audio)}}" type="audio/mp3" class="bg-[#023047] text-white">
                                Your browser does not support the audio element.
                            </audio>
                            @else
                                <p>Audio has already played</p>
                            @endif
                        @endif

                        @if (!empty($data->id_gambar))
                            <img src="{{asset('storage/gambar/'.$data->gambar->gambar)}}" alt="gambar soal" class="max-h-96 pb-2 mt-3">
                        @endif
                    </div>

                    {{-- paragraf --}}
                    <div class="px-2 pb-2">
                        <p class="mb-3 mt-5">{!! $data->text !!}</p>
                    </div>

                    {{-- soal --}}
                    <p class="mx-4 mb-3 bg-[#F3F3F3] mt-5">{{$data->soal}}</p>

                    {{-- jawaban --}}
                    <div class="my-2 mx-4">
                        <input type="radio" id="optiona" name="jawaban[{{ $data->id_soal }}]" value="A" class="w-5 h-5 pb-2">
                        <label for="option1">{{$data->jawaban_a}}</label><br>
    
                        <input type="radio" id="optionb" name="jawaban[{{ $data->id_soal }}]" value="B" class="w-5 h-5 pb-2">
                        <label for="option2">{{$data->jawaban_b}}</label><br>
    
                        <input type="radio" id="optionc" name="jawaban[{{ $data->id_soal }}]" value="C" class="w-5 h-5 pb-2">
                        <label for="option3">{{$data->jawaban_c}}</label><br>
    
                        <input type="radio" id="optiond" name="jawaban[{{ $data->id_soal }}]" value="D" class="w-5 h-5 pb-2">
                        <label for="option4">{{$data->jawaban_d}}</label><br>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="block" id="button">
            @if ($part->tanda < count($GetAllPart))
                <div class="flex justify-end items-end">
                    <button type="submit" name="tombol" value="next" id="nextButton" class="bg-[#0066FF] rounded px-10 py-3  hover:bg-gradient-to-br from-blue-700 to-blue-800 text-white bottom-8">Next</button>
                </div>
            @else    
                <div class="flex justify-end items-end">
                    <button type="submit" name="tombol" value="Submit" id="submitButton" class="bg-[#0066FF] rounded px-10 py-3  hover:bg-gradient-to-br from-blue-700 to-blue-800 text-white bottom-8">Submit</button>
                </div>
            @endif
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- matiin fungsi back pada browser --}}
    <script>
        history.replaceState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.replaceState(null, null, document.URL);
        });
    </script>

    {{-- Countdown --}}
    <script>
        // get form
        const form = document.getElementById('toeic_form');
        // Set durasi countdown (75 menit dalam milidetik)
        const countdownDuration = 75 * 60 * 1000;

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
            document.getElementById("countdown-nav").innerHTML = `${hours} h : ${minutes} m : ${seconds} s`;
            document.getElementById("countdown-sid").innerHTML = `${hours} h : ${minutes} m : ${seconds} s`;
            if (remainingTime < 0) {
                document.getElementById("countdown-nav").innerHTML = "Time Out";
                document.getElementById("countdown-sid").innerHTML = "Time Out";
                clearInterval(window.x);
                form.submit();
            }
        }, 100);

        function refreshPage() {
            window.location.reload(true); // Menggunakan parameter true untuk merefresh dari server
        }
    </script>

    {{-- Sesuai Waktu --}}
    <script>
        const formm = document.getElementById('toeic_form');

        // waktu akses dari session
        const endAccessTime = "{{ session('waktu_akhir') }}";
        const accessLimit = new Date(endAccessTime).getTime();

        const checkAccessTime = setInterval(() => {
            const now = Date.now();
            if (now >= accessLimit) {
                clearInterval(checkAccessTime);
                clearInterval(window.x);
                // Tampilkan status waktu habis
                document.getElementById("countdown-nav").innerHTML = "Time Out";
                document.getElementById("countdown-sid").innerHTML = "Time Out";
                formm.submit();
            }
        }, 1000);
    </script>

    <script>
        // menghentikan countdown ketika tombol submit ditekan
        document.getElementById("submitButton").addEventListener("click", function() {
            clearInterval(window.x);
        });
    </script>
@endsection
