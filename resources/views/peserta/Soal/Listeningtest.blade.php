@extends('layouts.Soal.toeic')

@section('title')
    TOEIC Test
@endsection

@section('timer')
    <div class="mr-3 text-blue-500">
        Listening
    </div>

    <span id="countdown-nav" class="bg-[#023047] p-2 rounded-lg text-white">Waktu Habis</span>
@endsection

@section('sidebar')
    <h1 class="text-center text-5xl font-bold px-5 mb-9 text-blue-500">
        Listening
    </h1>

    <div class="flex justify-center">
        <span id="countdown-sid" class="bg-[#023047] p-2 rounded-lg text-white text-4xl">Waktu</span>
    </div>
@endsection

@section('content')

    <form action="{{url('/ProsesJawabListening')}}" method="post">
        @csrf
        {{-- jika waktu habis --}}
        @if (session()->get('waktu') == 0) 
            {{-- menampilkan peringatan waktu habis --}}
            <div class="relative h-screen text-center hidden" id="waktuHabis">
                <div class="absolute top-[50%] left-[50%] md:top-[56%] translate-x-[-50%] translate-y-[-50%] z-10 p-2">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>

                    <h2 class="mb-2 mt-5 text-3xl font-bold">Time Out</h2>

                    <div class="mt-3 mb-8 text-md font-normal">You have used up the time you were given</div> 

                    <a href="{{url('/nilaiReading')}}" class="py-2 px-8 text-md font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Okay</a>
                </div>
            </div>
        
        {{-- jika belum --}}
        @else      
            <!-- Save id part -->
            <div class="">
                <input type="hidden" name="id_part" value="{{ $part->id_part}}">
            </div>

            <!-- Part Direction -->
            <div class="border rounded-xl relative z-30 text-justify block" id="petunjuk">
                {{-- judul --}}
                <h1 class="text-xl font-bold mb-5 bg-[#D7E1FB] p-3 rounded-t-lg border-b">
                    {{$part->part}} Listening - Question <span id="currentQuestion">{{$part->dari_nomor}} to {{$part->sampai_nomor}}</span>
                </h1>

                {{-- petunjuk --}}
                <p class="mx-4 mb-5">{{$part->petunjuk}}</p>

                {{-- gambar atau audio --}}
                <div class="mx-4">
                        @if (!$audioPart)
                            <audio id="audiopart" data-id-soal="" controls>
                                <source src="{{asset('storage/audio/'.$part->audio->audio)}}" type="audio/mp3" class="bg-[#023047] text-white">
                                Your browser does not support the audio element.
                            </audio>
                        @else
                            <p>Audio has already played</p>
                        @endif
                    @if (!empty($part->id_gambar))
                        <img src="{{asset('storage/gambar/'.$part->gambar->gambar)}}" alt="gambar soal" class="max-h-96 pb-2 mt-3">
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
                        <h1 class="text-xl font-bold mb-5 bg-[#F3F3F3] p-3 rounded-t-lg border-b">
                            Listening - Question <span id="currentQuestion">{{$data->nomor_soal}}</span>
                        </h1>

                        {{-- gambar atau audio --}}
                        <div class="mx-4">
                        @if (isset($audioSessions[$data->id_soal]) && !$audioSessions[$data->id_soal])
                            <audio class="audio" data-id-soal="{{ $data->id_soal }}" controls>
                                <source src="{{asset('storage/audio/'.$data->audio->audio)}}" type="audio/mp3" class="bg-[#023047] text-white">
                                Your browser does not support the audio element.
                            </audio>
                        @else
                            <p>Audio has already played</p>
                        @endif

                            @if (!empty($data->id_gambar))
                                <img src="{{asset('storage/gambar/'.$data->gambar->gambar)}}" alt="gambar soal" class="max-h-96 pb-2 mt-3">
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
        @endif
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Countdown --}}
    <script>
        // Set durasi countdown (45 menit dalam milidetik)
        const countdownDuration = 45 * 60 * 1000;

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
                clearInterval(window.x);
                setTimeout(refreshPage, 100);
            }
        }, 100);

        function refreshPage() {
            window.location.reload(true); // Menggunakan parameter true untuk merefresh dari server
        }
    </script>

    <script>
        // menghentikan countdown ketika tombol submit ditekan
        document.getElementById("submitButton").addEventListener("click", function() {
            clearInterval(window.x);
        });
    </script>

    <!-- 
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                console.log('DOM fully loaded and parsed');
                const audioElements = document.querySelectorAll('.audio');
                console.log('Found audio elements:', audioElements);

                audioElements.forEach(audioElement => {
                    const soalId = audioElement.getAttribute('data-id-soal');
                    console.log(`Audio element for soal ${soalId}`);
                    let playCount = 0;

                    audioElement.addEventListener('play', () => {
                        playCount++; // Increment play count
                        console.log(`Play count for soal ${soalId}: ${playCount}`);

                        // Limit plays to two
                        if (playCount >= 2) {
                            console.log(`Play limit reached for soal ${soalId}`);

                            // Disable playback controls
                            audioElement.controls = false;

                            // Display message or perform other actions
                            alert("You have reached the maximum playback limit.");

                            // Run AJAX
                            console.log('Sending AJAX request to set audio played for soal', soalId);
                            $.ajax({
                                url: `/set-audio-played/${soalId}`,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    console.log(response.status);
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX error:', error);
                                }
                            });
                        }
                    });
                });
            });
        </script>
    -->

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM fully loaded and parsed');
        const audioElements = document.querySelectorAll('.audio');
        console.log('Found audio elements:', audioElements.length);

        //audiopart
        const audiopart = document.getElementById('audiopart');
        console.log('Found audiopart:', audiopart);
        let count = 0;

        //function for part audio
        audiopart.addEventListener('play', () => {
                console.log(`Play event triggered for part}`); // Debug log
                count++; // Increment play count
                console.log(`Play count for soal : ${count}`); // Debug log

                // Limit plays to two
                if (count >= 2) {
                    console.log(`Play limit reached for soal`); // Debug log

                    // Display message or perform other actions
                    alert("You have reached the maximum playback limit.");

                    // Run AJAX
                    console.log('Sending AJAX request to set audio played for part'); // Debug log
                    $.ajax({
                        url: `/set-audio-played`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response.status); // Debug log
                            audioElement.remove();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', error); // Debug log
                        }
                    });
                }
        });

        //Function for every question
        audioElements.forEach(audioElement => {
            const soalId = audioElement.getAttribute('data-id-soal');
            console.log(`Audio element for soal ${soalId}`);
            let playCount = 0;

            audioElement.addEventListener('play', () => {
                console.log(`Play event triggered for soal ${soalId}`); // Debug log
                playCount++; // Increment play count
                console.log(`Play count for soal ${soalId}: ${playCount}`); // Debug log

                // Limit plays to two
                if (playCount >= 2) {
                    console.log(`Play limit reached for soal ${soalId}`); // Debug log

                    // Display message or perform other actions
                    alert("You have reached the maximum playback limit.");

                    // Run AJAX
                    console.log('Sending AJAX request to set audio played for soal', soalId); // Debug log
                    $.ajax({
                        url: `/set-audio-played/${soalId}`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response.status); // Debug log
                            audioElement.remove();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', error); // Debug log
                        }
                    });
                }
            });

            // Add a load event listener to ensure the audio is fully loaded
            audioElement.addEventListener('loadeddata', () => {
                console.log(`Audio loaded for soal ${soalId}`); // Debug log
            });
        });


    });
    </script>

@endsection