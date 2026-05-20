@extends('peserta.main')
@section('Title', $bank->bank . ' | Overall Review')

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">

        {{-- Breadcrumb --}}
        <nav class="flex mb-4 text-sm text-gray-500">
            <a href="/SelfStudy/Bank/{{ $bank->id_bank }}" class="hover:text-blue-600">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to {{ $bank->bank }}
            </a>
        </nav>

        {{-- Hero Banner --}}
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl p-6 sm:p-8 mb-6 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold">Overall Review</h1>
                <p class="mt-2 opacity-90">{{ $bank->bank }} — All Parts Progress</p>
            </div>
            <div class="absolute right-4 top-4 opacity-20">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 3v18h18" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M7 14l4-4 4 4 4-6" stroke="currentColor" stroke-width="2" fill="none"/>
                </svg>
            </div>
        </div>

        {{-- Stats Summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Total Rounds</div>
                <div class="text-2xl font-bold text-purple-600 mt-1">{{ $overall_chart['total_rounds'] }}</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Total Average Score</div>
                <div class="text-2xl font-bold text-emerald-500 mt-1">{{ $total_average_score }}</div>
                <div class="text-xs text-gray-400 mt-1">
                    Last score of all {{ $total_parts }} parts ÷ {{ $total_parts }}
                </div>
            </div>
        </div>

        {{-- Per-Part Detail (chart + table per card) --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Per-Part Attempt History</h2>

                @foreach ($parts_data as $part)
                    <div class="border border-gray-200 rounded-xl p-4 mb-3">
                        {{-- Part header --}}
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $part->part }}</h3>
                                <p class="text-xs text-gray-500">
                                    {{ $part->kategori }} &middot; Q{{ $part->dari_nomor }}-{{ $part->sampai_nomor }}
                                </p>
                            </div>
                            <div class="text-right text-sm">
                                <div>First: <span class="font-semibold">{{ $part->first_skor !== null ? $part->first_skor : '—' }}</span></div>
                                <div>Best: <span class="font-semibold text-emerald-500">{{ $part->best_skor !== null ? $part->best_skor : '—' }}</span></div>
                                <div class="text-xs text-gray-500">{{ $part->total }} attempts</div>
                            </div>
                        </div>

                        @if ($part->total > 0)
                            {{-- Mini chart per part --}}
                            <div class="relative mb-3" style="height: 180px;">
                                <canvas id="partChart{{ $part->id_part }}"></canvas>
                            </div>

                            {{-- Attempt table --}}
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-sm text-left text-gray-500 table-auto">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 border-2">Attempt</th>
                                            <th class="px-3 py-2 border-2">Benar</th>
                                            <th class="px-3 py-2 border-2">Salah</th>
                                            <th class="px-3 py-2 border-2">Skor</th>
                                            <th class="px-3 py-2 border-2">Durasi</th>
                                            <th class="px-3 py-2 border-2">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($part->all_attempts as $att)
                                            <tr class="border-b">
                                                <td class="px-3 py-2 border-2 text-center">#{{ $att->attempt_number }}</td>
                                                <td class="px-3 py-2 border-2 text-green-500">{{ $att->jumlah_benar }}</td>
                                                <td class="px-3 py-2 border-2 text-red-400">{{ $att->jumlah_salah }}</td>
                                                <td class="px-3 py-2 border-2 font-semibold">{{ $att->skor }}</td>
                                                <td class="px-3 py-2 border-2 text-xs">
                                                    {{ $att->durasi_detik ? gmdate('i:s', $att->durasi_detik) : '-' }}
                                                </td>
                                                <td class="px-3 py-2 border-2 text-xs">
                                                    {{ $att->created_at->format('d/m/Y H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Not attempted yet.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Scripts --}}
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
                        ticks: { stepSize: 10, callback: (v) => v },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: { grid: { display: false } }
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
                                    borderColor: 'rgba(99, 102, 241, 0.6)',
                                    backgroundColor: 'rgba(99, 102, 241, 0.08)',
                                    tension: 0.35, fill: true,
                                    pointRadius: 5, pointHoverRadius: 8,
                                    pointBackgroundColor: colors,
                                    pointBorderColor: '#fff', pointBorderWidth: 2,
                                    borderWidth: 2,
                                }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                interaction: { intersect: false, mode: 'index' },
                                scales: {
                                    ...commonScales,
                                    y: { ...commonScales.y, title: { display: true, text: 'Score' } },
                                    x: { ...commonScales.x, title: { display: true, text: 'Attempt' } }
                                },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(15, 23, 42, 0.95)', padding: 10,
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
    </section>
@endsection