@extends('peserta.main')
@section('Title', 'Self Study - ' . $bank->bank)

@section('content')
    <main class="p-5 md:ml-64 md:px-8 lg:px-12 h-auto pt-20">
        <div class="my-6 max-w-5xl mx-auto">

            {{-- Breadcrumb --}}
            <nav class="flex mb-5 text-xs text-slate-500 font-semibold uppercase tracking-wider">
                <a href="/SelfStudy" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Self Study
                </a>
            </nav>

            {{-- Hero Banner --}}
            <div class="bg-gradient-to-r from-blue-600 via-indigo-650 to-indigo-800 rounded-3xl p-6 sm:p-8 mb-8 text-white relative overflow-hidden shadow-sm border border-indigo-500/20">
                <div class="relative z-10 flex flex-col md:flex-row md:justify-between md:items-center gap-5">
                    <div>
                        <span class="inline-block text-[9px] font-bold px-2.5 py-1 rounded-full bg-white/20 backdrop-blur uppercase tracking-widest">Question Bank</span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold mt-3 tracking-tight">{{ $bank->bank }}</h1>
                        <p class="opacity-90 mt-2 text-xs sm:text-sm max-w-lg leading-relaxed">
                            No time limits, complete each section, and repeat them to achieve a perfect score.
                        </p>
                    </div>
                    <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Review"
                        class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 px-5 py-3 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all duration-200 shadow-sm active:scale-95 shrink-0 self-start md:self-auto">
                        <i class="fa-solid fa-chart-line text-sm"></i>
                        Review Overall History
                    </a>
                </div>
                <div class="absolute right-4 bottom-[-30px] opacity-10 pointer-events-none select-none">
                    <svg class="w-36 h-36 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C20.168 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="currentColor" stroke-width="1" fill="none"/>
                    </svg>
                </div>
            </div>

            {{-- Section Title --}}
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900">Available Sections</h2>
                <p class="text-gray-500 text-xs mt-0.5">Work through the sections. Complete the previous part to unlock the next.</p>
            </div>

            @if ($parts->isEmpty())
                <div class="bg-white border border-slate-100 rounded-3xl p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 text-slate-400">
                        <i class="fa-solid fa-list text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-base mb-1">No Parts Found</h3>
                    <p class="text-slate-400 text-xs">There are no parts inside this question bank yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($parts as $part)
                        <div class="relative bg-white border border-slate-100 rounded-2xl p-6 shadow-sm transition-all duration-300 flex flex-col justify-between min-h-[240px] {{ $part->is_unlocked ? 'hover:shadow-md hover:border-blue-200' : 'pointer-events-none' }}">

                            {{-- LOCKED OVERLAY (visible only when locked) --}}
                            @if (!$part->is_unlocked)
                                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] rounded-2xl flex flex-col items-center justify-center z-20 cursor-not-allowed transition-all duration-300">
                                    <div class="bg-white/95 backdrop-blur rounded-full p-3 mb-2.5 shadow-md">
                                        <i class="fa-solid fa-lock text-lg text-slate-700"></i>
                                    </div>
                                    <p class="text-sm font-bold text-white tracking-wider">LOCKED</p>
                                    <p class="text-[10px] text-slate-200 mt-1 px-4 text-center max-w-[200px] leading-snug">
                                        Complete the previous part to unlock this section
                                    </p>
                                </div>
                            @endif

                            {{-- Card content --}}
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full border
                                        {{ $part->kategori === 'Listening' 
                                            ? 'bg-blue-50/80 text-blue-700 border-blue-100/50' 
                                            : 'bg-emerald-50/80 text-emerald-700 border-emerald-100/50' }}">
                                        <i class="fa-solid {{ $part->kategori === 'Listening' ? 'fa-headphones' : 'fa-book' }} text-[11px]"></i>
                                        {{ $part->kategori }}
                                    </span>

                                    {{-- Status indicator (kanan atas) --}}
                                    @if ($part->is_completed)
                                        <span class="text-emerald-500 text-lg" title="Completed">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </span>
                                    @elseif ($part->is_unlocked && (int) $part->tanda === 1 && $part->total_attempts === 0)
                                        <span class="inline-flex items-center gap-1 text-[9px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-wider animate-pulse">
                                            <i class="fa-solid fa-play text-[8px]"></i> Start Here
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-bold text-base text-slate-800 mt-2">{{ $part->part }}</h3>
                                <p class="text-[11px] text-slate-500 font-semibold mt-1">
                                    <i class="fa-regular fa-file-lines text-slate-400 mr-0.5"></i> Questions {{ $part->dari_nomor }} - {{ $part->sampai_nomor }}
                                </p>
                            </div>

                            {{-- Stats: first & best --}}
                            @if ($part->is_unlocked && $part->total_attempts > 0)
                                <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-3 my-3 text-[11px] space-y-1.5">
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500">First Attempt Score</span>
                                        <strong class="text-slate-800 font-bold">{{ $part->first_skor }}</strong>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500">Best Attempt Score</span>
                                        <strong class="text-emerald-600 font-extrabold">{{ $part->best_skor }}</strong>
                                    </div>
                                    <div class="flex justify-between items-center text-[10px] text-slate-400 pt-1 border-t border-slate-100/50">
                                        <span>Total Attempts</span>
                                        <span>{{ $part->total_attempts }} attempts</span>
                                    </div>
                                </div>
                            @else
                                <div class="my-4 h-[1px] bg-slate-50"></div>
                            @endif

                            {{-- Action buttons --}}
                            @if ($part->is_unlocked)
                                <div class="mt-auto space-y-2">
                                    <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Part/{{ $part->token_part }}"
                                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-250 shadow-sm active:scale-95">
                                        {{ $part->is_completed ? 'Try Again' : 'Start Practice' }}
                                    </a>
                                    @if ($part->is_completed)
                                        <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Part/{{ $part->token_part }}/Result"
                                            class="block w-full text-center text-blue-600 hover:text-blue-700 text-xs font-bold transition-colors py-1">
                                            <i class="fa-solid fa-chart-pie mr-1"></i> View Result Analysis
                                        </a>
                                    @endif
                                </div>
                            @else
                                {{-- Disabled button --}}
                                <div class="mt-auto">
                                    <button disabled
                                        class="w-full bg-slate-100 text-slate-400 px-4 py-2.5 rounded-xl text-xs font-bold cursor-not-allowed flex items-center justify-center gap-1.5 border border-slate-200/50">
                                        <i class="fa-solid fa-lock text-[10px]"></i> Locked
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
@endsection
