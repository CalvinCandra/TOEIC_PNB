@extends('peserta.main')
@section('Title', $part->part . ' | Result')

@section('content')
    <main class="p-5 md:ml-64 md:px-8 lg:px-12 h-auto pt-20">
        <div class="my-6 max-w-5xl mx-auto">

            {{-- Breadcrumb --}}
            <nav class="flex mb-5 text-xs text-slate-500 font-semibold uppercase tracking-wider">
                <a href="/SelfStudy/Bank/{{ $bank->id_bank }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Sections
                </a>
            </nav>

            {{-- Hero Banner --}}
            <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-indigo-950 rounded-3xl p-6 sm:p-8 mb-8 text-white relative overflow-hidden shadow-sm border border-indigo-950/20">
                <div class="relative z-10">
                    <span class="inline-block text-[9px] font-bold px-2.5 py-1 rounded-full bg-white/20 backdrop-blur uppercase tracking-widest">Section Results</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold mt-3 tracking-tight">{{ $part->part }}</h1>
                    <p class="mt-2 text-slate-350 text-xs sm:text-sm max-w-xl leading-relaxed">
                        {{ $bank->bank }} &middot; {{ $part->kategori }}
                    </p>
                </div>
                <div class="absolute right-4 bottom-[-20px] opacity-10 pointer-events-none select-none">
                    <svg class="w-36 h-36 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C20.168 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="currentColor" stroke-width="1" fill="none"/>
                    </svg>
                </div>
            </div>

            {{-- Quiz Performance Scorecard --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 mb-8 shadow-sm relative overflow-hidden">
                {{-- Decorative background glows --}}
                <div class="absolute -right-16 -top-16 w-36 h-36 bg-blue-100/40 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -left-16 -bottom-16 w-36 h-36 bg-emerald-100/30 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex-1">
                        <span class="inline-flex items-center gap-1.5 text-[9px] font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-widest mb-3">
                            <i class="fa-solid fa-rocket animate-pulse"></i> Attempt #{{ $chartData['total'] }} Result
                        </span>
                        <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Practice Scorecard</h2>
                        <p class="text-slate-450 text-xs sm:text-sm mt-1 font-medium">Here is the detailed breakdown of your practice session for {{ $part->part }}.</p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-2 xl:grid-cols-4 gap-4 w-full lg:w-auto shrink-0">
                        {{-- Score Circle/Badge --}}
                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 border border-blue-100 rounded-2xl px-4 py-4 flex items-center gap-3 shadow-sm w-full">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-black text-base shadow-md shadow-blue-200 shrink-0">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] text-slate-405 font-bold uppercase tracking-wider">Practice Score</span>
                                <div class="flex items-baseline mt-0.5">
                                    <span class="text-2xl font-black text-indigo-950 tracking-tight">{{ $chartData['last'] }}</span>
                                    <span class="text-slate-400 font-bold text-xs ml-0.5">/ 100</span>
                                </div>
                            </div>
                        </div>

                        {{-- Correct Badge --}}
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-50/50 border border-emerald-100 rounded-2xl px-4 py-4 flex items-center gap-3 shadow-sm w-full">
                            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-base shadow-md shadow-emerald-200 shrink-0">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] text-slate-405 font-bold uppercase tracking-wider">Correct</span>
                                <div class="flex items-baseline mt-0.5">
                                    <span class="text-2xl font-black text-emerald-700 tracking-tight">{{ $chartData['last_benar'] }}</span>
                                    <span class="text-slate-400 font-bold text-[10px] ml-0.5">ques.</span>
                                </div>
                            </div>
                        </div>

                        {{-- Incorrect Badge --}}
                        <div class="bg-gradient-to-br from-rose-50 to-rose-50/50 border border-rose-100 rounded-2xl px-4 py-4 flex items-center gap-3 shadow-sm w-full">
                            <div class="w-10 h-10 rounded-full bg-rose-500 text-white flex items-center justify-center font-black text-base shadow-md shadow-rose-200 shrink-0">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] text-slate-405 font-bold uppercase tracking-wider">Incorrect</span>
                                <div class="flex items-baseline mt-0.5">
                                    <span class="text-2xl font-black text-rose-700 tracking-tight">{{ $chartData['last_salah'] }}</span>
                                    <span class="text-slate-400 font-bold text-[10px] ml-0.5">ques.</span>
                                </div>
                            </div>
                        </div>

                        {{-- Duration Badge --}}
                        @if($chartData['last_durasi'] !== null)
                            @php
                                $seconds = $chartData['last_durasi'];
                                $m = floor($seconds / 60);
                                $s = $seconds % 60;
                                $timeStr = $m > 0 ? "{$m}m {$s}s" : "{$s}s";
                            @endphp
                            <div class="bg-gradient-to-br from-amber-50 to-amber-50/50 border border-amber-100 rounded-2xl px-4 py-4 flex items-center gap-3 shadow-sm w-full">
                                <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center font-black text-base shadow-md shadow-amber-200 shrink-0">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <span class="block text-[9px] text-slate-405 font-bold uppercase tracking-wider">Duration</span>
                                    <div class="flex items-baseline mt-0.5">
                                        <span class="text-2xl font-black text-amber-700 tracking-tight">{{ $timeStr }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Stats Cards Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-8">
                
                {{-- Card 1: First Score --}}
                <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                            <span>First Score</span>
                            <i class="fa-solid fa-flag text-blue-500"></i>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1">{{ $chartData['first'] }}</div>
                    </div>
                </div>

                {{-- Card 2: Best Score --}}
                <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                            <span>Best Score</span>
                            <i class="fa-solid fa-trophy text-amber-500"></i>
                        </div>
                        <div class="text-2xl font-extrabold text-emerald-600 tracking-tight mt-1">{{ $chartData['best'] }}</div>
                    </div>
                </div>

                {{-- Card 3: Last Score --}}
                <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                            <span>Last Score</span>
                            <i class="fa-solid fa-graduation-cap text-indigo-500"></i>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1">{{ $chartData['last'] }}</div>
                    </div>
                </div>

                {{-- Card 4: Average --}}
                <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                            <span>Average</span>
                            <i class="fa-solid fa-calculator text-violet-500"></i>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1">{{ $chartData['avg'] }}</div>
                    </div>
                </div>

                {{-- Card 5: Attempts --}}
                <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                            <span>Attempts</span>
                            <i class="fa-solid fa-rotate-left text-slate-400"></i>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1">{{ $chartData['total'] }}</div>
                    </div>
                </div>

            </div>

            {{-- Chart Card --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 mb-8 shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-6">
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Score Progress Analysis</h2>
                        <p class="text-slate-400 text-xs mt-0.5">Visualization of your attempt history scores.</p>
                    </div>
                    <div class="flex gap-4 text-[10px] text-slate-500 font-bold uppercase tracking-wider">
                        <span class="flex items-center gap-1.5">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            First Attempt
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            Latest Attempt
                        </span>
                    </div>
                </div>

                @if ($chartData['total'] > 0)
                    <div class="relative w-full" style="height: 320px;">
                        <canvas id="progressChart"></canvas>
                    </div>
                @else
                    <div class="text-center py-12 text-slate-400 border border-dashed border-slate-200 rounded-2xl">
                        <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                            <i class="fa-solid fa-chart-line text-xl"></i>
                        </div>
                        <h4 class="font-bold text-slate-700 text-sm mb-1">No Practice Sessions Yet</h4>
                        <p class="text-xs text-slate-400">Complete a practice session to visualize score tracking charts here.</p>
                    </div>
                @endif
            </div>

            {{-- Detailed Question Analysis Card --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 mb-8 shadow-sm">
                @if (!empty($analysis))
                    <div class="mb-6">
                        <h2 class="text-base font-bold text-slate-800">Practice Question Analysis</h2>
                        <p class="text-slate-400 text-xs mt-0.5">Review your responses from this practice session. Incorrect answers highlight your response in red, keeping correct keys concealed to encourage practice and learning.</p>
                    </div>

                    <div class="space-y-6">
                        @foreach ($soal as $s)
                            @php
                                $itemAnalysis = $analysis[$s->id_soal] ?? null;
                                $userAnswer = $itemAnalysis['user_answer'] ?? null;
                                $isCorrect = $itemAnalysis['is_correct'] ?? false;
                            @endphp

                            <div class="border border-slate-150 rounded-2xl p-5 md:p-6 bg-slate-55/10">
                                
                                {{-- Question Header and Correctness Badge --}}
                                <div class="flex items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center shadow-inner font-extrabold text-xs">
                                            {{ $s->nomor_soal }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Question Detail</span>
                                    </div>
                                    <div>
                                        @if ($userAnswer === null)
                                            <span class="inline-flex items-center gap-1.5 text-[9px] font-bold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-wider">
                                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i> Unanswered
                                            </span>
                                        @elseif ($isCorrect)
                                            <span class="inline-flex items-center gap-1.5 text-[9px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i> Correct (Your Answer: {{ $userAnswer }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[9px] font-bold px-2.5 py-1 rounded-full bg-red-50 text-red-700 border border-red-100 uppercase tracking-wider">
                                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Incorrect (Your Answer: {{ $userAnswer }})
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Question Passage --}}
                                @if ($s->text)
                                    <div class="bg-slate-50 border border-slate-150 rounded-xl p-4 mb-4 text-slate-700 leading-relaxed text-xs sm:text-sm prose max-w-none">
                                        {!! $s->text !!}
                                    </div>
                                @endif

                                {{-- Media Content --}}
                                <div class="flex flex-col gap-3.5 mb-4">
                                    @if ($s->gambar)
                                        <div class="border border-slate-100 rounded-xl p-1.5 bg-slate-50 self-start max-w-full cursor-zoom-in group relative">
                                            <img src="{{ Storage::disk('s3')->url('gambar/' . $s->gambar->gambar) }}" class="zoomable-image max-h-56 object-contain rounded-lg">
                                        </div>
                                    @endif
                                    @if ($s->audio && $part->kategori === 'Listening')
                                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-2 w-full sm:w-max">
                                            <audio controls class="w-full h-8 sm:w-72">
                                                <source src="{{ Storage::disk('s3')->url('audio/' . $s->audio->audio) }}" type="audio/mpeg">
                                            </audio>
                                        </div>
                                    @endif
                                </div>

                                {{-- Question Stem --}}
                                @if ($s->soal)
                                    <p class="text-slate-800 font-bold text-xs sm:text-sm mb-4 leading-relaxed">{{ $s->soal }}</p>
                                @endif

                                {{-- Option Preview --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                                        @php
                                            $field = 'jawaban_' . strtolower($opt);
                                            $isSelected = ($userAnswer === $opt);
                                        @endphp
                                        @if ($s->$field)
                                            <div class="flex items-center p-3 border rounded-xl select-none text-xs sm:text-sm leading-snug
                                                @if ($isSelected && $isCorrect)
                                                    bg-emerald-50/70 border-emerald-500 text-emerald-950 font-semibold
                                                @elseif ($isSelected && !$isCorrect)
                                                    bg-red-50/70 border-red-400 text-red-950 font-semibold
                                                @else
                                                    bg-white border-slate-200 text-slate-500 opacity-80
                                                @endif">
                                                <div class="w-5 h-5 rounded-full shrink-0 flex items-center justify-center font-bold text-[10px] mr-2.5 shadow-inner
                                                    @if ($isSelected && $isCorrect)
                                                        bg-emerald-150 text-emerald-700
                                                    @elseif ($isSelected && !$isCorrect)
                                                        bg-red-150 text-red-700
                                                    @else
                                                        bg-slate-50 text-slate-450
                                                    @endif">
                                                    {{ $opt }}
                                                </div>
                                                <div class="w-full">{{ $s->$field }}</div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Direct/Historical Analysis Fallback --}}
                    <div class="text-center py-8 text-slate-400">
                        <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-450">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </div>
                        <h4 class="font-bold text-slate-700 text-sm mb-1">Detailed Question Breakdown Unavailable</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto leading-relaxed">Detailed correct/incorrect analysis is only available immediately after submitting a practice test. Practice again to generate a detailed, question-by-question breakdown here!</p>
                    </div>
                @endif
            </div>

            {{-- Actions Bar --}}
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Part/{{ $part->token_part }}"
                   class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-xl text-xs font-bold transition-all duration-200 shadow-sm hover:shadow active:scale-95 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-rotate-right text-[11px]"></i> Try Practice Again
                </a>
                <a href="/SelfStudy/Bank/{{ $bank->id_bank }}"
                   class="flex-1 text-center border border-slate-200 hover:bg-slate-50 text-slate-600 px-6 py-3.5 rounded-xl text-xs font-bold transition-all duration-200 active:scale-95 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i> Back to Sections
                </a>
            </div>

            {{-- Chart JS Script block --}}
            @if ($chartData['total'] > 0)
                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const canvas = document.getElementById('progressChart');
                        if (!canvas) return;

                        const labels = @json($chartData['labels']);
                        const scoreData = @json($chartData['data']);
                        const totalAttempts = scoreData.length;

                        // 🎨 Color interpolation per attempt: from blue-500 to emerald-500
                        const startColor = { r: 59, g: 130, b: 246 };   
                        const endColor   = { r: 16, g: 185, b: 129 };   

                        function interpolateColor(idx, total) {
                            if (total <= 1) return `rgb(${startColor.r}, ${startColor.g}, ${startColor.b})`;
                            const ratio = idx / (total - 1);
                            const r = Math.round(startColor.r + (endColor.r - startColor.r) * ratio);
                            const g = Math.round(startColor.g + (endColor.g - startColor.g) * ratio);
                            const b = Math.round(startColor.b + (endColor.b - startColor.b) * ratio);
                            return `rgb(${r}, ${g}, ${b})`;
                        }

                        const pointColors = scoreData.map((_, idx) => interpolateColor(idx, totalAttempts));

                        new Chart(canvas.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Score',
                                    data: scoreData,
                                    borderColor: 'rgba(99, 102, 241, 0.5)',
                                    backgroundColor: 'rgba(99, 102, 241, 0.04)',
                                    tension: 0.35,
                                    fill: true,
                                    pointRadius: 6,
                                    pointHoverRadius: 9,
                                    pointBackgroundColor: pointColors,
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    borderWidth: 2,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                interaction: {
                                    intersect: false,
                                    mode: 'index',
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        ticks: {
                                            stepSize: 10,
                                            font: { size: 10 }
                                        },
                                        grid: { color: 'rgba(0,0,0,0.03)' }
                                    },
                                    x: {
                                        ticks: { font: { size: 10 } },
                                        grid: { display: false }
                                    }
                                },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                        padding: 12,
                                        titleFont: { size: 12, weight: 'bold' },
                                        bodyFont: { size: 11 },
                                        cornerRadius: 10,
                                        callbacks: {
                                            label: (ctx) => `Score: ${ctx.parsed.y}`
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            @endif
    {{-- Global Image Lightbox Modal --}}
    <div id="image-modal" class="fixed inset-0 z-[1000] hidden bg-slate-900/90 backdrop-blur-sm cursor-zoom-out items-center justify-center p-4">
        <img id="modal-img" src="" alt="Zoomed Image" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl transition-transform duration-300">
        <button id="close-modal" class="absolute top-4 right-4 md:top-6 md:right-6 text-white bg-slate-800/50 hover:bg-slate-700 rounded-full w-10 h-10 flex items-center justify-center transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageModal = document.getElementById('image-modal');
            const modalImg = document.getElementById('modal-img');
            const clickableImages = document.querySelectorAll('.zoomable-image');

            clickableImages.forEach(img => {
                img.addEventListener('click', function(e) {
                    e.stopPropagation();
                    modalImg.src = this.src;
                    imageModal.classList.remove('hidden');
                    imageModal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                });
            });

            const closeModal = () => {
                imageModal.classList.add('hidden');
                imageModal.classList.remove('flex');
                document.body.style.overflow = '';
            };

            imageModal.addEventListener('click', closeModal);
            
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !imageModal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
