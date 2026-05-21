@extends('peserta.main')
@section('Title', 'Self Study')

@section('content')
    <main class="p-5 md:ml-64 md:px-8 lg:px-12 h-auto pt-20">
        <div class="my-6 max-w-5xl mx-auto">
            
            {{-- Hero Banner (aligned with dashSoal) --}}
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-3xl p-6 sm:p-8 mb-8 text-white relative overflow-hidden shadow-sm border border-slate-800/30">
                <div class="relative z-10">
                    <span class="bg-blue-600/95 backdrop-blur-md text-white text-[9px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm">Practice Mode</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold mt-3 tracking-tight">Self Study</h1>
                    <p class="mt-2 text-slate-300 text-xs sm:text-sm max-w-xl leading-relaxed">
                        Choose a bank to start practicing at your own pace. Each bank contains curated sections to help you master every part of the TOEIC test.
                    </p>
                </div>
                <div class="absolute right-4 bottom-[-20px] opacity-10 pointer-events-none select-none">
                    <svg class="w-36 h-36 sm:w-48 sm:h-48 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C20.168 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="currentColor" stroke-width="1" fill="none"/>
                    </svg>
                </div>
            </div>

            {{-- Section Title --}}
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Available Question Banks</h2>
                    <p class="text-gray-500 text-xs mt-0.5">Select a bank to view its parts and begin study sessions.</p>
                </div>
            </div>

            @if ($banks->isEmpty())
                <div class="bg-white border border-slate-100 rounded-3xl p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 text-slate-400">
                        <i class="fa-solid fa-folder-open text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-base mb-1">No Practice Banks Available</h3>
                    <p class="text-slate-400 text-xs">There are currently no Self Study banks available. Please check back later.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($banks as $bank)
                        <a href="/SelfStudy/Bank/{{ $bank->id_bank }}"
                            class="group flex flex-col bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300 relative overflow-hidden">
                            
                            {{-- Card Header: Title + Completion Check --}}
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1 pr-4">
                                    <h3 class="font-bold text-[15px] text-slate-800 group-hover:text-blue-600 transition-colors leading-snug">
                                        {{ $bank->bank }}
                                    </h3>
                                </div>
                                @if ($bank->progress_pct === 100)
                                    <span class="text-emerald-500 bg-emerald-50 w-6 h-6 rounded-full flex items-center justify-center text-[10px] shrink-0 shadow-inner" title="Completed">
                                        <i class="fa-solid fa-check font-extrabold"></i>
                                    </span>
                                @endif
                            </div>

                            {{-- Card Progress Bar --}}
                            <div class="mt-auto space-y-2">
                                <div class="flex justify-between text-[10px] text-slate-500 font-semibold">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-list-check text-slate-400 text-[11px]"></i> {{ $bank->parts_done }} / {{ $bank->total_parts }} parts
                                    </span>
                                    <span>{{ $bank->progress_pct }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ $bank->progress_pct }}%"></div>
                                </div>
                            </div>

                            @if ($bank->total_attempts > 0)
                                <div class="mt-4 pt-3 border-t border-slate-50 text-[10px] text-slate-500 flex items-center justify-between font-medium">
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-trophy text-amber-500"></i> Best: <strong class="text-emerald-600 font-bold ml-0.5">{{ $bank->best_skor }}</strong>
                                    </span>
                                    <span class="flex items-center gap-1 text-slate-400">
                                        <i class="fa-solid fa-rotate-left"></i> {{ $bank->total_attempts }} attempts
                                    </span>
                                </div>
                            @else
                                <div class="mt-4 pt-3 border-t border-slate-50 text-[10px] text-slate-400 italic">
                                    No attempts yet
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
@endsection
