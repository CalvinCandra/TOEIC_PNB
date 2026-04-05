@extends('admin.main')

@section('Title', 'Dashboard Admin')

@section('content')
    <main class="p-4 md:ml-64 h-auto pt-20">

        {{-- Welcome Banner --}}
        <div class="p-4 mb-6 rounded-xl bg-blue-950">
            <h3 class="text-lg font-bold text-white tracking-wide">
                👋 Welcome back, <span class="italic">{{ auth()->user()->name }}</span>
            </h3>
            <p class="text-sm text-blue-100 mt-1">Here's the participant overview for today.</p>
        </div>

        {{-- Donut Charts Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            @foreach ($sessions as $sesi)
                @php
                    $idx = array_search($sesi, array_column($chartData, 'sesi'));
                    $sessionData = $chartData[$idx];
                    $done = round($sessionData['data']['Done']);
                    $work = round($sessionData['data']['Work']);
                    $notYet = round($sessionData['data']['Not Yet']);
                    $total = round($sessionData['total']);
                @endphp

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-300 p-5 flex flex-col items-center gap-3 hover:shadow-md transition-shadow">
                    {{-- Session Label --}}
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-widest">{{ $sesi }}</h2>

                    {{-- Donut Chart --}}
                    <div class="relative w-36 h-36">
                        <canvas id="chartSession{{ $loop->index }}" class="w-full h-full"></canvas>
                        {{-- Center Label --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-gray-800">{{ $total }}</span>
                            <span class="text-xs text-gray-400">Participants</span>
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div class="flex flex-col gap-1.5 w-full mt-1">
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span>
                                Done
                            </div>
                            <span class="font-semibold text-gray-800">{{ $done }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                                In Progress
                            </div>
                            <span class="font-semibold text-gray-800">{{ $work }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-400 inline-block"></span>
                                Not Yet
                            </div>
                            <span class="font-semibold text-gray-800">{{ $notYet }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Top Scorer Tables per Sesi --}}
        <h2 class="text-base font-semibold text-gray-700 mb-4">🏆 Top Scorers per Session</h2>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
            @foreach (['Session 1', 'Session 2'] as $sesi)
                @php
                    $topPeserta = \App\Models\Peserta::with('user')
                        ->where('sesi', $sesi)
                        ->where('status', 'Sudah')
                        ->orderByRaw('(skor_listening + skor_reading) DESC')
                        ->take(5)
                        ->get();
                @endphp

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-300 overflow-hidden hover:shadow-md transition-shadow">
                    {{-- Table Header --}}
                    <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-700">{{ $sesi }}</h3>
                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">Top 5</span>
                    </div>

                    @if ($topPeserta->isEmpty())
                        <div class="px-5 py-8 text-center text-sm text-gray-400">
                            No completed participants yet.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                                    <tr>
                                        <th class="px-5 py-3 w-8">#</th>
                                        <th class="px-5 py-3">Name</th>
                                        <th class="px-5 py-3 text-center">Listening</th>
                                        <th class="px-5 py-3 text-center">Reading</th>
                                        <th class="px-5 py-3 text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($topPeserta as $i => $p)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-5 py-3">
                                                @if ($i === 0)
                                                    <span class="text-amber-500 font-bold">🥇</span>
                                                @elseif($i === 1)
                                                    <span class="text-gray-400 font-bold">🥈</span>
                                                @elseif($i === 2)
                                                    <span class="text-amber-700 font-bold">🥉</span>
                                                @else
                                                    <span class="text-gray-400 text-xs">{{ $i + 1 }}</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="font-medium text-gray-800">{{ $p->nama_peserta }}</div>
                                                <div class="text-xs text-gray-400">{{ $p->nim }}</div>
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <span
                                                    class="inline-block bg-blue-50 text-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                                                    {{ $p->skor_listening }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <span
                                                    class="inline-block bg-purple-50 text-purple-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                                                    {{ $p->skor_reading }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <span
                                                    class="inline-block bg-emerald-50 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-full">
                                                    {{ $p->skor_listening + $p->skor_reading }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </main>

    {{-- Donut Chart Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chartData = @json($chartData);

            chartData.forEach((session, index) => {
                const ctx = document.getElementById(`chartSession${index}`);
                if (!ctx) return;

                const done = Math.round(session.data['Done'] ?? 0);
                const work = Math.round(session.data['Work'] ?? 0);
                const notYet = Math.round(session.data['Not Yet'] ?? 0);

                const isEmpty = done === 0 && work === 0 && notYet === 0;

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Done', 'In Progress', 'Not Yet'],
                        datasets: [{
                            data: isEmpty ? [1] : [done, work, notYet],
                            backgroundColor: isEmpty ? ['#D1D5DB'] : ['#059669', '#D97706',
                                '#E11D48'
                            ],
                            borderWidth: 0,
                            hoverOffset: isEmpty ? 0 : 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: !isEmpty,
                                callbacks: {
                                    label: (ctx) => ` ${ctx.label}: ${ctx.raw}`
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            duration: 600,
                        }
                    }
                });
            });
        });
    </script>
@endsection
