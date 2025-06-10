@extends('layouts.Soal.toeic')

@section('title')
TOEIC Test
@endsection

{{-- @dd(session()->get('waktu')) --}}

@section('timer')
<div class="mr-3 text-blue-500">
    Listening
</div>

<span id="countdown-nav" class="bg-[#023047] p-2 rounded-lg text-white">Timer</span>
@endsection

@section('sidebar')
<h1 class="text-center text-5xl font-bold px-5 mb-9 text-blue-500">
    Listening
</h1>

<div class="flex justify-center">
    <span id="countdown-sid" class="bg-[#023047] p-2 rounded-lg text-white text-4xl">Timer</span>
</div>
@endsection

@section('content')

<form action="{{url('/ProsesJawabListening')}}" method="post" id="toeic_form">
    @csrf
    <!-- Save id part -->
    <div class="">
        <input type="hidden" name="id_part" value="{{ $part->id_part}}">
    </div>

    <!-- Part Direction -->
    <div class="border rounded-xl relative z-30 text-justify block" id="petunjuk">
        {{-- judul --}}
        <h1 class="text-xl font-bold mb-5 bg-[#D7E1FB] p-3 rounded-t-lg border-b">
            {{$part->part}} Listening - Question <span id="currentQuestion">{{$part->dari_nomor}} to
                {{$part->sampai_nomor}}</span>
        </h1>

        {{-- petunjuk --}}
        <div class="px-2 pb-2">
            <p class="">{!! $part->petunjuk !!}</p>
        </div>

        {{-- gambar atau audio --}}
        <div class="mt-3">
            @if(!empty($part->id_audio))
            <audio id="audiopart" class="audiopart" data-id-part="{{ $part->id_part }}" controls>
                <source src="{{ asset('storage/audio/' . $part->audio->audio) }}" type="audio/mp3"
                    class="bg-[#023047] text-white">
                Your browser does not support the audio element.
            </audio>
            @endif
            @if (!empty($part->id_gambar))
            <img src="{{asset('storage/gambar/'.$part->gambar->gambar)}}" alt="gambar part soal"
                class="max-h-96 pb-2 mt-3">
            @endif
        </div>

    </div>

    <div class="block" id="soal">
        @foreach ($soalListening as $data)
        <div class="border rounded-lg relative z-30 text-justify mt-10 mb-5">
            <!-- Save id soal -->
            <div class="">
                <input type="hidden" id="id_soal[]" name="id_soal[]" value="{{ $data->id_soal }}">
            </div>

            {{-- judul --}}
            <h1 class="text-md font-bold mb-5 bg-[#F3F3F3] p-3 rounded-t-lg border-b">
                Listening - Question <span id="currentQuestion">{{$data->nomor_soal}}</span>
            </h1>

            {{-- gambar atau audio --}}
            <div class="mx-4">
                @if(!empty($data->id_audio))
                <audio class="audio" data-id-soal="{{ $data->id_soal }}" controls>
                    <source src="{{asset('storage/audio/'.$data->audio->audio)}}" type="audio/mp3"
                        class="bg-[#023047] text-white">
                    Your browser does not support the audio element.
                </audio>
                @endif
                @if (!empty($data->id_gambar))
                <img src="{{asset('storage/gambar/'.$data->gambar->gambar)}}" alt="gambar soal"
                    class="max-h-96 pb-2 mt-3">
                @endif
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

                @if (!is_null($data->jawaban_d))
                <input type="radio" id="optiond_{{ $data->id_soal }}" name="jawaban[{{ $data->id_soal }}]" value="D"
                    class="w-5 h-5 pb-2">
                <label for="optiond_{{ $data->id_soal }}">{{$data->jawaban_d}}</label><br>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    <div class="block" id="button">
        @if ($part->tanda < count($GetAllPart)) <div class="flex justify-end items-end">
            <button type="submit" name="tombol" value="next" id="nextButton"
                class="bg-[#0066FF] rounded px-10 py-3  hover:bg-gradient-to-br from-blue-700 to-blue-800 text-white bottom-8">Next</button>
    </div>
    @else
    <div class="flex justify-end items-end">
        <button type="submit" name="tombol" value="Submit" id="submitButton"
            class="bg-[#0066FF] rounded px-10 py-3  hover:bg-gradient-to-br from-blue-700 to-blue-800 text-white bottom-8">Submit</button>
    </div>
    @endif
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Countdown --}}
<script>
    // get form 
        const form = document.getElementById('toeic_form');
        // Set durasi countdown (45 menit dalam milidetik)
        const countdownDuration = 46 * 60 * 1000;

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
            if (remainingTime <= 0) {
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
    document.addEventListener('DOMContentLoaded', () => {
            const audioElements = document.querySelectorAll('.audio');

            audioElements.forEach(audio => {
                const id = audio.getAttribute('data-id-soal');
                handleAudioPlay(audio, id);
            });

            const audiopart = document.getElementById('audiopart');
            if (audiopart) {
                const partId = audiopart.getAttribute('data-id-part');
                handleAudioPlay(audiopart, partId);
            }

            const audioForm = document.getElementById('toeic_form');
            audioForm.addEventListener('submit', () => {
                resetPlayCounts();
            });
        });

        function handleAudioPlay(audio, id) {
            let playCount = localStorage.getItem(`audio-play-count-${id}`) || 0;

            if (playCount >= 5) {
                audio.setAttribute('disabled', 'disabled');
                audio.removeAttribute('controls');
            }

            audio.addEventListener('play', () => {
                playCount = localStorage.getItem(`audio-play-count-${id}`) || 0;
                playCount++;
                localStorage.setItem(`audio-play-count-${id}`, playCount);

                if (playCount >= 5) {
                    audio.setAttribute('disabled', 'disabled');
                    audio.removeAttribute('controls');
                }
            });
        }

        function resetPlayCounts() {
            const audioElements = document.querySelectorAll('.audio');
            audioElements.forEach(audio => {
                const id = audio.getAttribute('data-id-soal');
                localStorage.removeItem(`audio-play-count-${id}`);
            });

            const audiopart = document.getElementById('audiopart');
            if (audiopart) {
                const partId = audiopart.getAttribute('data-id-part');
                localStorage.removeItem(`audio-play-count-${partId}`);
            }
        }

</script>

@endsection