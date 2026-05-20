@extends('petugas.main')
@section('Title', 'Self Study History | Detail Participant')

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Participant Detail</h1>

        <div class="p-3 sm:p-5 antialiased">

            {{-- Breadcrumb --}}
            <nav class="flex mb-4 text-sm text-gray-500">
                <a href="/dash{{ $routePrefix }}SelfStudyHistoryPeserta" class="hover:text-brand">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Participant List
                </a>
            </nav>

            {{-- Participant Info Card --}}
            <div class="bg-white shadow-md sm:rounded-lg overflow-hidden p-3 mb-4">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $peserta->nama_peserta }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        NIM: <span class="font-medium text-gray-700">{{ $peserta->nim }}</span>
                        &nbsp;&middot;&nbsp;
                        Sesi: <span class="font-medium text-gray-700">{{ $peserta->sesi }}</span>
                    </p>
                </div>
            </div>

            {{-- ============ MODE: BANKS (list bank yang dikerjakan) ============ --}}
            @if ($viewMode === 'banks')
                <div class="bg-white shadow-md sm:rounded-lg overflow-hidden p-3">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Banks Attempted</h3>

                        @if ($banks->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                This participant has not attempted any Self Study yet.
                            </div>
                        @else
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-sm text-left text-gray-500 table-auto">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-4 border-2">No</th>
                                            <th scope="col" class="px-4 py-3 border-2">Bank</th>
                                            <th scope="col" class="px-4 py-3 border-2">Sesi</th>
                                            <th scope="col" class="px-4 py-3 border-2">Parts Done</th>
                                            <th scope="col" class="px-4 py-3 border-2">Total Attempts</th>
                                            <th scope="col" class="px-4 py-3 border-2">Best Score</th>
                                            <th scope="col" class="px-4 py-3 border-2">Last Activity</th>
                                            <th scope="col" class="px-4 py-3 border-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banks as $b)
                                            <tr class="border-b">
                                                <th class="px-4 py-3 border-2">{{ $loop->iteration }}</th>
                                                <td class="px-4 py-3 border-2">{{ $b->bank->bank ?? '-' }}</td>
                                                <td class="px-4 py-3 border-2">{{ $b->bank->sesi_bank ?? '-' }}</td>
                                                <td class="px-4 py-3 border-2 text-center">{{ $b->parts_done }}</td>
                                                <td class="px-4 py-3 border-2 text-center">{{ $b->total_attempts }}</td>
                                                <td class="px-4 py-3 border-2 font-semibold">{{ $b->best_skor }}%</td>
                                                <td class="px-4 py-3 border-2 text-xs">
                                                    {{ \Carbon\Carbon::parse($b->last_activity)->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-4 py-3 border-2">
                                                    <ul class="flex py-1 text-sm">
                                                        <li>
                                                            <a href="/dash{{ $routePrefix }}SelfStudyHistoryPeserta/{{ $peserta->id_peserta }}/Bank/{{ $b->id_bank }}"
                                                                class="flex items-center w-full px-4 py-2 text-green-400 hover:bg-gray-100 hover:scale-95">
                                                                <i class="fa-solid fa-chart-line me-1"></i>
                                                                View Chart
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            {{-- ============ MODE: BANK (detail Part dalam 1 bank) ============ --}}
            @elseif($viewMode === 'bank')

                {{-- Overall Chart Card --}}
                <div class="bg-white shadow-md sm:rounded-lg overflow-hidden p-3 mb-4">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $bank->bank }} - Overall Progress</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="text-xs text-gray-500 uppercase">Total Rounds</div>
                                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $overall_chart['total_rounds'] }}</div>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="text-xs text-gray-500 uppercase">Best Avg</div>
                                <div class="text-2xl font-bold text-green-500 mt-1">{{ $overall_chart['best_avg'] }}%</div>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="text-xs text-gray-500 uppercase">Last Avg</div>
                                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $overall_chart['last_avg'] }}%</div>
                            </div>
                        </div>

                        @if ($overall_chart['total_rounds'] > 0)
                            <div class="relative" style="height: 250px;">
                                <canvas id="overallChart"></canvas>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500">No attempt data yet.</div>
                        @endif
                    </div>
                </div>

                {{-- Per-Part Attempt History --}}
                <div class="bg-white shadow-md sm:rounded-lg overflow-hidden p-3">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Per-Part Attempt History</h3>

                        @foreach ($parts_data as $part)
                            <div class="border border-gray-200 rounded-lg p-4 mb-3">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $part->part }}</h4>
                                        <p class="text-xs text-gray-500">
                                            {{ $part->kategori }}
                                            &middot;
                                            Q{{ $part->dari_nomor }}-{{ $part->sampai_nomor }}
                                        </p>
                                    </div>
                                    <div class="text-right text-sm">
                                        <div>First: <span class="font-semibold">{{ $part->first_skor !== null ? $part->first_skor . '%' : '-' }}</span></div>
                                        <div>Best: <span class="font-semibold text-green-500">{{ $part->best_skor !== null ? $part->best_skor . '%' : '-' }}</span></div>
                                        <div class="text-xs text-gray-500">{{ $part->total }} attempts</div>
                                    </div>
                                </div>

                                @if ($part->total > 0)
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
                                                        <td class="px-3 py-2 border-2 font-semibold">{{ $att->skor }}%</td>
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

                @if ($overall_chart['total_rounds'] > 0)
                    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const canvas = document.getElementById('overallChart');
                            if (!canvas) return;

                            const labels = @json($overall_chart['labels']);
                            const scoreData = @json($overall_chart['data']);
                            const totalRounds = scoreData.length;

                            const startColor = { r: 168, g: 85, b: 247 };
                            const endColor   = { r: 236, g: 72, b: 153 };

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
                                                callback: (v) => v + '%'
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
                                                label: (ctx) => `Avg: ${ctx.parsed.y}%`
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                @endif

            @endif
        </div>
    </section>
@endsection
