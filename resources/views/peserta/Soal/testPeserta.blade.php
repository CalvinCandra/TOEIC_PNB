@extends('layouts.test.toeic')

@section('title')
    TOEIC Test
@endsection

@section('timer')
    <div class="mr-3 text-blue-500">
        Reading
    </div>
    <div class="bg-[#023047] p-2 rounded-lg text-white">
        00 : 40 : 21
    </div>
@endsection

@section('sidebar')
    <h1 class="text-xl font-bold px-5 max-sm:px-2">
        All Question
    </h1>
    <div class="grid max-sm:grid-cols-3 grid-cols-5 gap-2 px-5 py-8 max-sm:px-2 content-center">
        @foreach ($questions as $question)
            <a href="#question{{ $question }}" class="bg-[#0066FF] text-white p-2 rounded flex justify-center items-center">{{ $question }}</a>
        @endforeach
    </div>
@endsection

@section('content')
            <h1 class="text-xl font-bold">
                Reading - Question 1-4
            </h1>
            <div class="bg-[#F3F3F3] mt-8 p-4">
                <!-- Soal disini (include gambar/audio) -->
                <img src="{{asset('favicon/img1.jpg')}}" alt="gambar soal" class="max-h-48 pb-2">
                <audio id="audio" controls>
                <source src="{{asset('audio/niki.mp3')}}" type="audio/mp3" class="bg-[#023047] text-white">
                Your browser does not support the audio element.
            </audio>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio, incidunt in numquam alias ducimus ut nihil fugit eos maiores minus perferendis quasi corrupti amet! Vero nihil quibusdam nam optio odio!
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio, incidunt in numquam alias ducimus ut nihil fugit eos maiores minus perferendis quasi corrupti amet! Vero nihil quibusdam nam optio odio!
                </p>
            </div>
            <!-- Jawaban -->
            <div class="mt-2 p-4">
                <p class="mb-2">Lorem ipsum dolor sit amet consectetur adipisicing? </p>
                <input type="radio" id="option1" name="options" value="Option 1" class="w-5 h-5 pb-2">
                <label for="option1">Option 1</label><br>

                <input type="radio" id="option2" name="options" value="Option 2" class="w-5 h-5 pb-2">
                <label for="option2">Option 2</label><br>

                <input type="radio" id="option3" name="options" value="Option 3" class="w-5 h-5 pb-2">
                <label for="option3">Option 3</label><br>

                <input type="radio" id="option4" name="options" value="Option 4" class="w-5 h-5 pb-2">
                <label for="option4">Option 4</label><br>
            </div>
            <div class="flex justify-end items-end">
                <input type="submit" value="Next" class="bg-[#0066FF] text-white rounded px-10 py-3 
                hover:bg-gradient-to-r hover:from-blue-500 hover:via-green-500 hover:to-purple-500 
                hover:animate-gradient absolute bottom-8">
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    // Get the audio element
                    var audio = document.getElementById('audio');

                    // Add an event listener to handle when the audio is played
                    audio.addEventListener('play', function() {
                        // Disable the audio controls after it starts playing
                        audio.controls = false;
                    });

                    // Add an event listener to handle when the audio ends
                    audio.addEventListener('ended', function() {
                        // Disable the audio controls after it ends
                        audio.controls = false;
                    });
                });
            </script>
@endsection