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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Total Rounds</div>
                <div class="text-2xl font-bold text-purple-600 mt-1">{{ $chartData['total_rounds'] }}</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Best Avg Score</div>
                <div class="text-2xl font-bold text-emerald-500 mt-1">{{ $chartData['best_avg'] }}%</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Last Avg Score</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $chartData['last_avg'] }}%</div>
            </div>
        </div>

        {{-- Chart Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6">
            <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Average Score Per Round</h2>
                        <p class="text-xs text-gray-500">Each round = one attempt cycle across parts</p>
                    </div>
                    <div class="flex gap-3 text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            <span class="inline-block w-3 h-3 rounded-full bg-purple-500"></span>
                            First
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="inline-block w-3 h-3 rounded-full bg-pink-500"></span>
                            Latest
                        </span>
                    </div>
                </div>

                @if ($chartData['total_rounds'] > 0)
                    <div class="relative" style="height: 320px;">
                        <canvas id="overallChart"></canvas>
                    </div>
                @else
                    <div class="text-center py-10 text-gray-400">
                        <i class="fa-solid fa-chart-line text-4xl mb-2"></i>
                        <p>No data yet. Start practicing to see your progress!</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Per-Part Summary Table --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Per-Part Summary</h2>
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-gray-500 table-auto">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 border-2">Part</th>
                                <th class="px-4 py-3 border-2">Category</th>
                                <th class="px-4 py-3 border-2 text-right">First</th>
                                <th class="px-4 py-3 border-2 text-right">Best</th>
                                <th class="px-4 py-3 border-2 text-right">Attempts</th>
                                <th class="px-4 py-3 border-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partsStats as $p)
                                <tr class="border-b">
                                    <td class="px-4 py-3 border-2 font-semibold text-gray-900">{{ $p->part }}</td>
                                    <td class="px-4 py-3 border-2">{{ $p->kategori }}</td>
                                    <td class="px-4 py-3 border-2 text-right">
                                        {{ $p->first_skor !== null ? $p->first_skor . '%' : '—' }}
                                    </td>
                                    <td class="px-4 py-3 border-2 text-right text-emerald-500 font-semibold">
                                        {{ $p->best_skor !== null ? $p->best_skor . '%' : '—' }}
                                    </td>
                                    <td class="px-4 py-3 border-2 text-right">{{ $p->total_attempts }}</td>
                                    <td class="px-4 py-3 border-2 text-center">
                                        @if ($p->is_completed)
                                            <span class="text-green-500"><i class="fa-solid fa-circle-check"></i></span>
                                        @elseif ($p->is_unlocked)
                                            <span class="text-yellow-500"><i class="fa-regular fa-circle"></i></span>
                                        @else
                                            <span class="text-gray-400"><i class="fa-solid fa-lock"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- 🩹 Chart.js script DI DALAM section --}}
        @if ($chartData['total_rounds'] > 0)
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const canvas = document.getElementById('overallChart');
                    if (!canvas) return;

                    const labels = @json($chartData['labels']);
                    const scoreData = @json($chartData['data']);
                    const totalRounds = scoreData.length;

                    // 🎨 Color gradient: Purple-500 → Pink-500
                    const startColor = { r: 168, g: 85, b: 247 };   // Purple-500
                    const endColor   = { r: 236, g: 72, b: 153 };   // Pink-500

                    function interpolateColor(idx, total) {
                        if (total <= 1) return `rgb(${startColor.r}, ${startColor.g}, ${startColor.b})`;
                        const ratio = idx / (total - 1);
                        const r = Math.round(startColor.r + (endColor.r - startColor.r) * ratio);
                        const g = Math.round(startColor.g + (endColor.g - startColor.g) * ratio);
                        const b = Math.round(startColor.b + (endColor.b - startColor.b) * ratio);
                        return `rgb(${r}, ${g}, ${b})`;
                    }

                    const pointColors = scoreData.map((_, idx) => interpolateColor(idx, totalRounds));

                    new Chart(canvas.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Avg Score',
                                data: scoreData,
                                borderColor: 'rgba(168, 85, 247, 0.6)',
                                backgroundColor: 'rgba(168, 85, 247, 0.08)',
                                tension: 0.35,
                                fill: true,
                                pointRadius: 7,
                                pointHoverRadius: 10,
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
                                        callback: (val) => val + '%'
                                    },
                                    title: { display: true, text: 'Avg Score (%)' },
                                    grid: { color: 'rgba(0,0,0,0.05)' }
                                },
                                x: {
                                    title: { display: true, text: 'Round' },
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    padding: 12,
                                    titleFont: { size: 13, weight: 'bold' },
                                    bodyFont: { size: 12 },
                                    callbacks: {
                                        label: (ctx) => {
                                            const partsCount = @json($chartData['parts_count']);
                                            const idx = ctx.dataIndex;
                                            return [
                                                `Avg: ${ctx.parsed.y}%`,
                                                `${partsCount[idx]} parts attempted`
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endif
    </section>
@endsection
