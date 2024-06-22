@extends('layouts.Soal.toeic')

@section('title')
    TOEIC Test
@endsection

@section('timer')
    <div class="mr-3 text-blue-500">
        Listening
    </div>
    @if (session()->get('waktu') <= 0)
        <span class="bg-[#023047] p-2 rounded-lg text-white">Waktu Habis</span>
    @else    
        <span id="countdown" class="bg-[#023047] p-2 rounded-lg text-white">Waktu Habis</span>
    @endif
@endsection

@section('sidebar')
    <h1 class="text-xl font-bold px-5 max-sm:px-2">
        All Question
    </h1>
    <div class="grid max-sm:grid-cols-3 grid-cols-5 gap-2 px-5 py-8 max-sm:px-2 content-center">
        @foreach ($soal as $questions)
            <div class="bg-[#0066FF] text-white p-2 rounded flex justify-center items-center">{{ $questions->nomor_soal }}</div>
        @endforeach


    </div>
@endsection

@section('content')

    @if (session()->get('waktu') <= 0)
        <div class="relative h-screen text-center">
            <div class="absolute top-[50%] left-[50%] md:top-[56%] translate-x-[-50%] translate-y-[-50%] z-10 h-64 w-64 p-2 md:h-96 md:w-96">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>

                <h2 class="mb-2 mt-5 text-3xl font-bold">Time Out</h2>

                <div class="mt-3 mb-8 text-md font-normal">You have used up the time you were given</div> 

                <a href="{{url('/nilaiListening')}}" class="py-2 px-8 text-md font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Okay</a>
            </div>
        </div>
    @else    
        <form action="{{url('/ProsesJawabListening')}}" method="post">
            @csrf
            <h1 class="text-xl font-bold mb-5">
                Listening - Question {{$soalListening->nomor_soal}}
            </h1>
        
            <!-- Soal disini (include gambar/audio) -->
            <div class="bg-[#F3F3F3] mt-2 p-4 overflow-auto rounded max-h-[32rem] sm:max-h-80">
                @if (!empty($soalListening->id_audio))
                    @if (!$audioPlayed)
                    <audio id="audio" controls>
                        <source src="{{asset('storage/audio/'.$soalListening->audio->audio)}}" type="audio/mp3" class="bg-[#023047] text-white">
                        Your browser does not support the audio element.
                    </audio>
                    @else
                        <p>Audio has already played</p>
                    @endif
                @endif
                @if ($soalListening->text != null)    
                    <div class="h-52 overflow-y-auto">
                        <p>
                            {{$soalListening->text}}
                        </p>
                    </div>
                @endif
                
            </div>
            <!-- Save id soal -->
            <div class="">
                <input type="hidden" name="id_soal" value="{{ $soalListening->id_soal }}">
            </div>

            <!-- Jawaban -->
            <div class="mt-2 p-4">
                <p class="mb-2">{{$soalListening->soal}}</p>
                <input type="radio" id="optiona" name="jawaban" value="A" class="w-5 h-5 pb-2">
                <label for="option1">{{$soalListening->jawaban_a}}</label><br>

                <input type="radio" id="optionb" name="jawaban" value="B" class="w-5 h-5 pb-2">
                <label for="option2">{{$soalListening->jawaban_b}}</label><br>

                <input type="radio" id="optionc" name="jawaban" value="C" class="w-5 h-5 pb-2">
                <label for="option3">{{$soalListening->jawaban_c}}</label><br>

                <input type="radio" id="optiond" name="jawaban" value="D" class="w-5 h-5 pb-2">
                <label for="option4">{{$soalListening->jawaban_d}}</label><br>
            </div>

            @if ($soalListening->nomor_soal != count($soal))
                <div class="flex justify-end items-end">
                    <button type="submit" name="tombol" value="next" class="bg-[#0066FF] rounded px-10 py-3  hover:bg-gradient-to-br from-blue-700 to-blue-800 text-white absolute bottom-8">Next</button>
                </div>
            @else    
                <div class="flex justify-end items-end">
                    <button type="submit" name="tombol" value="Submit" class="bg-[#0066FF] rounded px-10 py-3  hover:bg-gradient-to-br from-blue-700 to-blue-800 text-white absolute bottom-8">Submit</button>
                </div>
            @endif

        </form>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const audioElement = document.getElementById('audio');
      
        // Counter to track the number of plays
        let playCount = 0;
      
        // Event listener for audio play event
        audioElement.addEventListener('play', () => {
          playCount++; // Increment play count
          console.log(playCount);
      
          // Limit plays to two
          if (playCount >= 2) {
            console.log(playCount);

            // Disable playback controls
            audioElement.controls = false;
            
            // Display message or perform other actions
            alert("You have reached the maximum playback limit.");

            //run ajax
            console.log('action');
            $.ajax({
                url: '/set-audio-played',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response.status);
                    }
            });
          }
        });
    </script>

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
            document.getElementById("countdown").innerHTML = `${hours} h : ${minutes} m : ${seconds} s`;
            if (remainingTime < 0) {
                clearInterval(window.x);
                setTimeout(refreshPage, 100);
            }
        }, 100);

        function refreshPage() {
            window.location.reload(true); // Menggunakan parameter true untuk merefresh dari server
        }
    </script>
@endsection