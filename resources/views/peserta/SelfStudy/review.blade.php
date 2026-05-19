@extends('peserta.main')
@section('Title', 'Review | ' . $bank->bank)

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">

        {{-- Breadcrumb --}}
        <nav class="flex mb-4 text-sm text-gray-500">
            <a href="/SelfStudy/Bank/{{ $bank->id_bank }}" class="hover:text-blue-600">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to {{ $bank->bank }}
            </a>
        </nav>

        {{-- Hero Banner --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 sm:p-8 mb-6 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold">Overall Review</h1>
                <p class="mt-2 opacity-90">{{ $bank->bank }} — All Parts Progress</p>
            </div>
            <div class="absolute right-4 top-4 opacity-20">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C20.168 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="currentColor" stroke-width="1" fill="none"/>
                </svg>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Total Rounds</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $chartData['total_rounds'] }}</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Best Avg Score</div>
                <div class="text-2xl font-bold text-green-500 mt-1">{{ $chartData['best_avg'] }}%</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Last Avg Score</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $chartData['last_avg'] }}%</div>
            </div>
        </div>

        {{-- Chart Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Average Score Progress (All Parts)</h2>
                <p class="text-xs text-gray-500 mb-3">
                    Each round represents one attempt across multiple parts. Score is averaged.
                </p>
                @if ($chartData['total_rounds'] > 0)
                    <div class="relative" style="height: 320px;">
                        <canvas id="overallChart"></canvas>
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">No attempts yet. Start practicing to see your progress!</p>
                @endif
            </div>
        </div>

        {{-- Part Summary Table --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Part Summary</h2>
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-gray-500 table-auto">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-4 border-2">Part</th>
                                <th scope="col" class="px-4 py-3 border-2">Category</th>
                                <th scope="col" class="px-4 py-3 border-2">First</th>
                                <th scope="col" class="px-4 py-3 border-2">Best</th>
                                <th scope="col" class="px-4 py-3 border-2">Attempts</th>
                                <th scope="col" class="px-4 py-3 border-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partsStats as $p)
                                <tr class="border-b">
                                    <td class="px-4 py-3 border-2 font-semibold">{{ $p->part }}</td>
                                    <td class="px-4 py-3 border-2">{{ $p->kategori }}</td>
                                    <td class="px-4 py-3 border-2">
                                        {{ $p->first_skor !== null ? $p->first_skor . '%' : '-' }}
                                    </td>
                                    <td class="px-4 py-3 border-2 font-semibold text-green-500">
                                        {{ $p->best_skor !== null ? $p->best_skor . '%' : '-' }}
                                    </td>
                                    <td class="px-4 py-3 border-2 text-center">{{ $p->total_attempts }}</td>
                                    <td class="px-4 py-3 border-2 text-center">
                                        @if ($p->is_completed)
                                            <span class="text-green-500"><i class="fa-solid fa-check-circle"></i></span>
                                        @elseif ($p->is_unlocked)
                                            <span class="text-yellow-500"><i class="fa-solid fa-circle"></i></span>
                                        @else
                                            <span class="text-gray-400"><i class="fa-solid fa-lock"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 border-2">
                                        No parts available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@if ($chartData['total_rounds'] > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('overallChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Avg Score',
                    data: @json($chartData['data']),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.3, fill: true, pointRadius: 6, pointHoverRadius: 9,
                    pointBackgroundColor: 'rgb(34, 197, 94)',
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 10,
                            callback: (val) => val + '%'
                        },
                        title: { display: true, text: 'Average Score (%)' }
                    },
                    x: { title: { display: true, text: 'Round (attempt cycle)' } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => {
                                const idx = ctx.dataIndex;
                                const partsCount = @json($chartData['parts_count']);
                                return [`Avg Score: ${ctx.parsed.y}%`, `Parts: ${partsCount[idx]}`];
                            }
                        }
                    }
                }
            }
        });
    </script>
@endif
