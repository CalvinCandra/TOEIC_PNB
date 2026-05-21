@extends('peserta.main')
@section('Title', $bank->bank . ' | Overall Review')

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
            <div class="bg-gradient-to-r from-violet-900 via-indigo-850 to-indigo-950 rounded-3xl p-6 sm:p-8 mb-8 text-white relative overflow-hidden shadow-sm border border-violet-900/20">
                <div class="relative z-10">
                    <span class="inline-block text-[9px] font-bold px-2.5 py-1 rounded-full bg-white/20 backdrop-blur uppercase tracking-widest">Performance Dashboard</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold mt-3 tracking-tight">Overall Review</h1>
                    <p class="mt-2 text-slate-300 text-xs sm:text-sm max-w-xl leading-relaxed">
                        {{ $bank->bank }} &middot; Overall progress analytics across all parts.
                    </p>
                </div>
                <div class="absolute right-4 bottom-[-20px] opacity-10 pointer-events-none select-none">
                    <svg class="w-36 h-36 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3v18h18" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M7 14l4-4 4 4 4-6" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                </div>
            </div>

            {{-- Stats Summary --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                
                {{-- Total Rounds --}}
                <div class="bg-white border border-slate-150 rounded-2xl p-6 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Total Rounds Practiced</div>
                        <div class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1">{{ $overall_chart['total_rounds'] }}</div>
                        <p class="text-[10px] text-slate-400 mt-1">Sum of all sections completed</p>
                    </div>
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center text-sm shadow-inner shrink-0 ml-4">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>
                </div>

                {{-- Total Average Score --}}
                <div class="bg-white border border-slate-150 rounded-2xl p-6 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Overall Average Score</div>
                        <div class="text-2xl font-extrabold text-emerald-600 tracking-tight mt-1">{{ $total_average_score }}</div>
                        <p class="text-[10px] text-slate-400 mt-1">Average score across all {{ $total_parts }} parts</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center text-sm shadow-inner shrink-0 ml-4">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>

            </div>

            {{-- Per-Part Detail --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-base font-bold text-slate-800">Part Attempt Histories</h2>
                    <p class="text-slate-400 text-xs mt-0.5">Detailed statistics and graphical tracking for each section.</p>
                </div>

                <div class="space-y-6">
                    @foreach ($parts_data as $part)
                        <div class="border border-slate-150 rounded-2xl p-5 md:p-6 bg-slate-50/20">
                            
                            {{-- Part Card Header --}}
                            <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 mb-5 pb-4 border-b border-slate-100">
                                <div>
                                    <span class="inline-flex items-center gap-1 text-[9px] font-bold px-2 py-0.5 rounded-full border
                                        {{ $part->kategori === 'Listening' 
                                            ? 'bg-blue-50/80 text-blue-700 border-blue-100/55' 
                                            : 'bg-emerald-50/80 text-emerald-700 border-emerald-100/55' }}">
                                        <i class="fa-solid {{ $part->kategori === 'Listening' ? 'fa-headphones' : 'fa-book' }} text-[10px]"></i>
                                        {{ $part->kategori }}
                                    </span>
                                    <h3 class="font-extrabold text-slate-850 text-base mt-2">{{ $part->part }}</h3>
                                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">
                                        Questions {{ $part->dari_nomor }} - {{ $part->sampai_nomor }}
                                    </p>
                                </div>
                                
                                <div class="flex gap-4 text-xs font-semibold text-slate-600 sm:text-right sm:justify-end">
                                    <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-100 shadow-sm text-center">
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">First</div>
                                        <div class="text-slate-800 font-bold mt-0.5">{{ $part->first_skor !== null ? $part->first_skor : '—' }}</div>
                                    </div>
                                    <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-100 shadow-sm text-center">
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Best</div>
                                        <div class="text-emerald-600 font-extrabold mt-0.5">{{ $part->best_skor !== null ? $part->best_skor : '—' }}</div>
                                    </div>
                                    <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-100 shadow-sm text-center">
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Attempts</div>
                                        <div class="text-slate-500 font-bold mt-0.5">{{ $part->total }}</div>
                                    </div>
                                </div>
                            </div>

                            @if ($part->total > 0)
                                {{-- Mini chart per part --}}
                                <div class="relative w-full mb-5" style="height: 180px;">
                                    <canvas id="partChart{{ $part->id_part }}"></canvas>
                                </div>

                                {{-- Attempt Table --}}
                                <div class="overflow-hidden border border-slate-150 rounded-xl bg-white shadow-sm">
                                    <div class="overflow-x-auto w-full">
                                        <table class="w-full text-xs text-left text-slate-600 table-auto border-collapse">
                                            <thead>
                                                <tr class="text-[10px] text-slate-450 font-bold uppercase bg-slate-50/75 border-b border-slate-150">
                                                    <th class="px-4 py-3 text-center">Attempt</th>
                                                    <th class="px-4 py-3 text-emerald-600"><i class="fa-solid fa-circle-check mr-0.5"></i> Correct</th>
                                                    <th class="px-4 py-3 text-red-500"><i class="fa-solid fa-circle-xmark mr-0.5"></i> Incorrect</th>
                                                    <th class="px-4 py-3 font-semibold text-slate-800">Score</th>
                                                    <th class="px-4 py-3"><i class="fa-regular fa-clock mr-0.5"></i> Duration</th>
                                                    <th class="px-4 py-3">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100">
                                                @foreach ($part->all_attempts as $att)
                                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                                        <td class="px-4 py-2.5 text-center font-bold text-slate-400">#{{ $att->attempt_number }}</td>
                                                        <td class="px-4 py-2.5 text-emerald-600 font-medium">{{ $att->jumlah_benar }}</td>
                                                        <td class="px-4 py-2.5 text-red-400 font-medium">{{ $att->jumlah_salah }}</td>
                                                        <td class="px-4 py-2.5 font-bold text-slate-800">{{ $att->skor }}</td>
                                                        <td class="px-4 py-2.5 text-slate-500">
                                                            {{ $att->durasi_detik ? gmdate('i:s', $att->durasi_detik) : '-' }}
                                                        </td>
                                                        <td class="px-4 py-2.5 text-slate-400 font-medium">
                                                            {{ $att->created_at->format('d/m/Y H:i') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-6 text-slate-400 italic text-xs border border-dashed border-slate-200 rounded-xl bg-white">
                                    <i class="fa-solid fa-circle-info mr-1 text-[11px]"></i> Not attempted yet. Start practicing to generate reports.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    {{-- Line charts rendering script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function interpolate(idx, total, startC, endC) {
                if (total <= 1) return `rgb(${startC.r}, ${startC.g}, ${startC.b})`;
                const ratio = idx / (total - 1);
                return `rgb(${Math.round(startC.r + (endC.r - startC.r) * ratio)}, `
                     + `${Math.round(startC.g + (endC.g - startC.g) * ratio)}, `
                     + `${Math.round(startC.b + (endC.b - startC.b) * ratio)})`;
            }

            const commonScales = {
                y: {
                    beginAtZero: true, max: 100,
                    ticks: { stepSize: 20, font: { size: 9 } },
                    grid: { color: 'rgba(0,0,0,0.03)' }
                },
                x: {
                    ticks: { font: { size: 9 } },
                    grid: { display: false }
                }
            };

            {{-- Per-Part Mini Charts --}}
            @foreach ($parts_data as $part)
                @if ($part->total > 0)
                (function () {
                    const canvas = document.getElementById('partChart{{ $part->id_part }}');
                    if (!canvas) return;

                    const data = @json($part->chart['data']);
                    const blue    = { r: 59, g: 130, b: 246 };
                    const emerald = { r: 16, g: 185, b: 129 };
                    const colors = data.map((_, i) => interpolate(i, data.length, blue, emerald));

                    new Chart(canvas.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: @json($part->chart['labels']),
                            datasets: [{
                                label: 'Score',
                                data: data,
                                borderColor: 'rgba(99, 102, 241, 0.45)',
                                backgroundColor: 'rgba(99, 102, 241, 0.03)',
                                tension: 0.35, fill: true,
                                pointRadius: 4, pointHoverRadius: 7,
                                pointBackgroundColor: colors,
                                pointBorderColor: '#fff', pointBorderWidth: 1.5,
                                borderWidth: 1.5,
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            interaction: { intersect: false, mode: 'index' },
                            scales: commonScales,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)', padding: 10,
                                    titleFont: { size: 11, weight: 'bold' },
                                    bodyFont: { size: 10 },
                                    cornerRadius: 8,
                                    callbacks: { label: (ctx) => `Score: ${ctx.parsed.y}` }
                                }
                            }
                        }
                    });
                })();
                @endif
            @endforeach

        });
    </script>
@endsection