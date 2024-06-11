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
        @foreach ($totalQuestions as $index => $questions)
            <a href="/soal/{{$index + 1}}" class="bg-[#0066FF] text-white p-2 rounded flex justify-center items-center">{{ $questions }}</a>
        @endforeach


    </div>
@endsection

@section('content')
    <form action="/soal/actionSoal" method="post">
        <h1 class="text-xl font-bold">
            Reading - Question {{$question->id_soal}}
        </h1>
        <div class="bg-[#F3F3F3] mt-8 p-4">
            <!-- Soal disini (include gambar/audio) -->
            @if (!empty($question->id_gambar))
                <img src="{{asset('favicon/img1.jpg')}}" alt="gambar soal" class="max-h-48 pb-2">
            @endif
            @if (!empty($question->id_audio))
                <audio id="audio" controls>
                <source src="{{asset('audio/niki.mp3')}}" type="audio/mp3" class="bg-[#023047] text-white">
                Your browser does not support the audio element.
            @endif
        </audio>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus consequuntur enim nobis, voluptate ut sint voluptatem porro excepturi quidem perferendis doloremque, esse eligendi nam. Quisquam tenetur inventore sapiente rerum itaque?
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Debitis, provident? Fugit aspernatur asperiores deserunt laborum rerum repellat quod, ab voluptas eligendi nam temporibus itaque voluptatibus dolorem, ipsum amet, autem nisi.
            </p>
        </div>
        <!-- Save id soal -->
        <div class="">
            <input type="hidden" name="id_soal" value="{{ $id_soal }}">
        </div>
        <!-- Jawaban -->
        <div class="mt-2 p-4">
            <p class="mb-2">{{$question->soal}}</p>
            <input type="radio" id="optiona" name="optiona" value="a" class="w-5 h-5 pb-2">
            <label for="option1">{{$question->jawaban_a}}</label><br>

            <input type="radio" id="optionb" name="optionb" value="b" class="w-5 h-5 pb-2">
            <label for="option2">{{$question->jawaban_b}}</label><br>

            <input type="radio" id="optionc" name="optionc" value="c" class="w-5 h-5 pb-2">
            <label for="option3">{{$question->jawaban_c}}</label><br>

            <input type="radio" id="optiond" name="optionsd" value="d" class="w-5 h-5 pb-2">
            <label for="option4">{{$question->jawaban_d}}</label><br>
        </div>
        <div class="flex justify-end items-end">
            <input type="submit" value="Next" class="bg-[#0066FF] text-white rounded px-10 py-3 
            hover:bg-gradient-to-r hover:from-blue-500 hover:via-green-500 hover:to-purple-500 
            hover:animate-gradient absolute bottom-8">
        </div>
    </form>
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