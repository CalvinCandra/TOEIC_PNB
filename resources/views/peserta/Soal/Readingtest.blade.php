@extends('layouts.Soal.toeic')

@section('title')
    TOEIC Test
@endsection

@section('timer')
    <div class="mr-3 text-blue-500">
        Reading
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

                <a href="{{url('/nilaiReading')}}" class="py-2 px-8 text-md font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Okay</a>
            </div>
        </div>
    @else    
        <form action="{{url('/ProsesJawabReading')}}" method="post">
            @csrf
            <h1 class="text-xl font-bold">
                Reading - Question {{$soalReading->nomor_soal}}
            </h1>
            <!-- Soal disini (include gambar/audio) -->
            @if (!empty($soalReading->id_gambar))
                <img src="{{asset('storage/gambar/'.$soalReading->gambar->gambar)}}" alt="gambar soal" class="max-h-48 pb-2 mt-3">
            @endif
            <div class="bg-[#F3F3F3] mt-2 p-4">
                {{-- jika ada text, maka tampilkan --}}
                @if ($soalReading->text != null)    
                    <div class="h-52 overflow-auto">
                        <p class="">
                            {{$soalReading->text}}
                        </p>   
                    </div>
                @endif
            </div>
            <!-- Save id soal -->
            <div class="">
                <input type="hidden" name="id_soal" value="{{ $soalReading->id_soal }}">
            </div>

            <!-- Jawaban -->
            <div class="mt-2 p-4">
                <p class="mb-2">{{$soalReading->soal}}</p>
                <input type="radio" id="optiona" name="jawaban" value="A" class="w-5 h-5 pb-2">
                <label for="option1">{{$soalReading->jawaban_a}}</label><br>

                <input type="radio" id="optionb" name="jawaban" value="B" class="w-5 h-5 pb-2">
                <label for="option2">{{$soalReading->jawaban_b}}</label><br>

                <input type="radio" id="optionc" name="jawaban" value="C" class="w-5 h-5 pb-2">
                <label for="option3">{{$soalReading->jawaban_c}}</label><br>

                <input type="radio" id="optiond" name="jawaban" value="D" class="w-5 h-5 pb-2">
                <label for="option4">{{$soalReading->jawaban_d}}</label><br>
            </div>

            @if ($soalReading->nomor_soal != count($soal))
                <div class="flex justify-end items-end">
                    <button type="submit" name="tombol" value="next" class="bg-[#0066FF] text-white rounded px-10 py-3 
                    hover:bg-gradient-to-r hover:from-blue-500 hover:via-green-500 hover:to-purple-500 
                    hover:animate-gradient absolute bottom-8">Next</button>
                </div>
            @else    
                <div class="flex justify-end items-end">
                    <button type="submit" name="tombol" value="Submit" class="bg-[#0066FF] text-white rounded px-10 py-3 
                    hover:bg-gradient-to-r hover:from-blue-500 hover:via-green-500 hover:to-purple-500 
                    hover:animate-gradient absolute bottom-8">Submit</button>
                </div>
            @endif

        </form>
    @endif
@endsection