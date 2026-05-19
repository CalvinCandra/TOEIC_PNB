@extends('peserta.main')
@section('Title', 'Self Study')

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">

        {{-- Hero Banner (mirror dashboard peserta) --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 sm:p-8 mb-6 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold">Self Study 📚</h1>
                <p class="mt-2 opacity-90">
                    Choose a bank to start practicing. Each bank has its own set of parts to master.
                </p>
            </div>
            <div class="absolute right-4 top-4 opacity-20">
                <svg class="w-24 h-24 sm:w-32 sm:h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C20.168 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="currentColor" stroke-width="1" fill="none"/>
                </svg>
            </div>
        </div>

        {{-- Section Title --}}
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Available Banks</h2>

        @if ($banks->isEmpty())
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center">
                <p class="text-gray-500">No Self Study banks available yet. Please check back later.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($banks as $bank)
                    <a href="/SelfStudy/Bank/{{ $bank->id_bank }}"
                        class="block bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg transition">

                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full bg-purple-100 text-purple-700">
                                    {{ $bank->sesi_bank }}
                                </span>
                                <h3 class="font-bold text-lg text-gray-900 mt-2">{{ $bank->bank }}</h3>
                            </div>
                            @if ($bank->progress_pct === 100)
                                <span class="text-green-500 text-sm font-semibold">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                            @endif
                        </div>

                        {{-- Progress bar --}}
                        <div class="mt-3">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>{{ $bank->parts_done }} / {{ $bank->total_parts }} parts</span>
                                <span class="font-semibold">{{ $bank->progress_pct }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $bank->progress_pct }}%"></div>
                            </div>
                        </div>

                        @if ($bank->total_attempts > 0)
                            <div class="mt-3 text-sm text-gray-600 flex items-center gap-3">
                                <span>
                                    Best: <strong class="text-green-500">{{ $bank->best_skor }}%</strong>
                                </span>
                                <span class="text-gray-300">|</span>
                                <span>{{ $bank->total_attempts }} attempts</span>
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
