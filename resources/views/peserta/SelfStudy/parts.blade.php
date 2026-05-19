@extends('peserta.main')
@section('Title', 'Self Study - ' . $bank->bank)

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">

        {{-- Breadcrumb --}}
        <nav class="flex mb-4 text-sm text-gray-500">
            <a href="/SelfStudy" class="hover:text-blue-600">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Banks
            </a>
        </nav>

        {{-- Hero Banner --}}
        <div
            class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 sm:p-8 mb-6 text-white relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full bg-white/20 backdrop-blur">
                        {{ $bank->sesi_bank }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold mt-2">{{ $bank->bank }}</h1>
                    <p class="opacity-90 mt-1">Self Study Mode - No time limit, practice freely</p>
                </div>
                <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Review"
                    class="inline-flex items-center gap-2 bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50">
                    <i class="fa-solid fa-chart-line"></i>
                    Review Overall
                </a>
            </div>
        </div>

        {{-- Section Title --}}
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Parts in This Bank</h2>

        @if ($parts->isEmpty())
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center">
                <p class="text-gray-500">No parts in this bank yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($parts as $part)
                    <div
                        class="relative bg-white border border-gray-200 rounded-2xl p-5 transition
                                {{ $part->is_unlocked ? 'hover:shadow-lg' : 'pointer-events-none' }}">

                        {{-- LOCKED OVERLAY (visible only when locked) --}}
                        @if (!$part->is_unlocked)
                            <div
                                class="absolute inset-0 bg-gray-900/70 rounded-2xl flex flex-col items-center justify-center z-20 cursor-not-allowed">
                                <div class="bg-white rounded-full p-4 mb-3 shadow-lg">
                                    <i class="fa-solid fa-lock text-4xl text-gray-700"></i>
                                </div>
                                <p class="text-lg font-bold text-white tracking-wider">LOCKED</p>
                                <p class="text-xs text-gray-200 mt-1 px-4 text-center max-w-xs">
                                    Complete the previous part to unlock this part
                                </p>
                            </div>
                        @endif

                        {{-- Card content (tetap render utk maintain layout, ditutup overlay) --}}
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span
                                    class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full
                                    {{ $part->kategori === 'Listening' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                    <i
                                        class="fa-solid {{ $part->kategori === 'Listening' ? 'fa-headphones' : 'fa-book' }} me-1"></i>
                                    {{ $part->kategori }}
                                </span>
                                <h3 class="font-bold text-lg text-gray-900 mt-2">{{ $part->part }}</h3>
                                <p class="text-xs text-gray-500">Q{{ $part->dari_nomor }}-{{ $part->sampai_nomor }}</p>
                            </div>

                            {{-- Status indicator (kanan atas) --}}
                            @if ($part->is_completed)
                                <span class="text-green-500 text-2xl" title="Completed">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                            @elseif ($part->is_unlocked && (int) $part->tanda === 1 && $part->total_attempts === 0)
                                <span
                                    class="inline-block text-xs font-semibold px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                    <i class="fa-solid fa-play me-1"></i>
                                    Start Here
                                </span>
                            @endif
                        </div>

                        {{-- Stats: first & best --}}
                        @if ($part->is_unlocked && $part->total_attempts > 0)
                            <div class="bg-gray-50 rounded-lg p-3 mb-3 text-sm">
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600">First Score</span>
                                    <strong class="text-gray-900">{{ $part->first_skor }}%</strong>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-600">Best Score</span>
                                    <strong class="text-green-500">{{ $part->best_skor }}%</strong>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Attempts</span>
                                    <span class="text-gray-500">{{ $part->total_attempts }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Action button --}}
                        @if ($part->is_unlocked)
                            <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Part/{{ $part->token_part }}"
                                class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-semibold">
                                {{ $part->is_completed ? 'Try Again' : 'Start' }}
                            </a>
                            @if ($part->is_completed)
                                <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Part/{{ $part->token_part }}/Result"
                                    class="block w-full text-center mt-2 text-blue-600 hover:underline text-sm">
                                    <i class="fa-solid fa-chart-line me-1"></i>
                                    View Result
                                </a>
                            @endif
                        @else
                            {{-- Disabled button (akan ditutup overlay) --}}
                            <button disabled
                                class="w-full bg-gray-200 text-gray-400 px-4 py-2.5 rounded-lg font-semibold cursor-not-allowed">
                                <i class="fa-solid fa-lock me-1"></i>
                                Locked
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
