@extends('petugas.main')

@section('Title', 'Dashboard Petugas')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-20">

    {{-- Welcome Banner --}}
    <div class="p-4 mb-6 rounded-xl bg-brand shadow-md">
        <h3 class="text-lg font-bold text-white tracking-wide">
            Welcome back, <span class="italic">{{ auth()->user()->name }}</span>
        </h3>
        <p class="text-sm text-blue-100 mt-1">Here's the participant overview for today.</p>
    </div>

    {{-- Session Filter Dropdown --}}
    <div class="mb-6">
        <label for="sessionFilter" class="block mb-2 text-sm font-semibold text-gray-700">Select Session</label>
        <select id="sessionFilter"
            class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full sm:w-64 p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
            @foreach ($sessions as $sesi)
                <option value="{{ $sesi }}" {{ $loop->first ? 'selected' : '' }}>{{ $sesi }}</option>
            @endforeach
        </select>
    </div>

    {{-- Session Sections --}}
    @foreach ($sessions as $sesi)
        <div class="session-section" data-session="{{ $sesi }}" {{ !$loop->first ? 'style=display:none' : '' }}>

            {{-- Overview + Top Scorers side by side --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                {{-- Session Overview Donut --}}
                <div>
                    <h2 class="text-base font-semibold text-gray-700 mb-4">📊 {{ $sesi }} Overview</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @php
                            $sd = $allChartData[$sesi] ?? null;
                            $done = round($sd['data']['Done'] ?? 0);
                            $work = round($sd['data']['Work'] ?? 0);
                            $notYet = round($sd['data']['Not Yet'] ?? 0);
                            $total = round($sd['total'] ?? 0);
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center gap-3 hover:shadow-md transition-shadow">
                            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-widest">{{ $sesi }}</h2>
                            <div class="relative w-36 h-36">
                                <canvas id="chartSession-{{ $sesi }}" class="w-full h-full"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-2xl font-bold text-gray-800">{{ $total }}</span>
                                    <span class="text-xs text-gray-400">Participants</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1.5 w-full mt-1">
                                <div class="flex items-center justify-between text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 inline-block"></span>
                                        Done
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $done }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-600 inline-block"></span>
                                        In Progress
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $work }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-600 inline-block"></span>
                                        Not Yet
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $notYet }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top Scorers --}}
                <div>
                    <h2 class="text-base font-semibold text-gray-700 mb-4">🏆 {{ $sesi }} — Top Scorers</h2>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow h-full">
                        <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-700">{{ $sesi }}</h3>
                            <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">Top 5</span>
                        </div>
                        @php
                            $topPeserta = $allTopScorers[$sesi] ?? collect();
                        @endphp
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
                                                    <span class="inline-block bg-blue-50 text-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                                                        {{ $p->skor_listening }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-3 text-center">
                                                    <span class="inline-block bg-purple-50 text-purple-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                                                        {{ $p->skor_reading }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-3 text-center">
                                                    <span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-full">
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
                </div>

            </div>

            {{-- Jurusan Charts --}}
            <h2 class="text-base font-semibold text-gray-700 mb-4">📊 {{ $sesi }} — Participants per Major</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
                @foreach ($allJurusanData[$sesi] as $idx => $j)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center gap-3 hover:shadow-md transition-shadow">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-widest">{{ $j['jurusan'] }}</h2>
                        <div class="relative w-36 h-36">
                            <canvas id="chartJurusan-{{ $sesi }}-{{ $idx }}" class="w-full h-full"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-2xl font-bold text-gray-800">{{ $j['total'] }}</span>
                                <span class="text-xs text-gray-400">Participants</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5 w-full mt-1">
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 inline-block"></span>
                                    Done
                                </div>
                                <span class="font-semibold text-gray-800">{{ $j['data']['Done'] }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-600 inline-block"></span>
                                    In Progress
                                </div>
                                <span class="font-semibold text-gray-800">{{ $j['data']['Work'] }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600 inline-block"></span>
                                    Not Yet
                                </div>
                                <span class="font-semibold text-gray-800">{{ $j['data']['Not Yet'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @endforeach

</main>

{{-- Chart Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const allChartData = @json($allChartData);
    const allJurusanData = @json($allJurusanData);

    const renderedSessions = {};

    function makeDonut(ctx, data, labels) {
        const done = Math.round(data['Done'] ?? 0);
        const work = Math.round(data['Work'] ?? 0);
        const notYet = Math.round(data['Not Yet'] ?? 0);
        const isEmpty = done === 0 && work === 0 && notYet === 0;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: isEmpty ? [1] : [done, work, notYet],
                    backgroundColor: isEmpty ? ['#D1D5DB'] : ['#059669', '#D97706', '#E11D48'],
                    borderWidth: 0,
                    hoverOffset: isEmpty ? 0 : 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: !isEmpty,
                        callbacks: {
                            label: (c) => ` ${c.label}: ${c.raw}`
                        }
                    }
                },
                animation: { animateRotate: true, duration: 600 }
            }
        });
    }

    function renderChartsForSession(sesi) {
        if (renderedSessions[sesi]) return;
        renderedSessions[sesi] = true;

        const sd = allChartData[sesi];
        if (sd) {
            const ctx = document.getElementById(`chartSession-${sesi}`);
            if (ctx) makeDonut(ctx, sd.data, ['Done', 'In Progress', 'Not Yet']);
        }

        const jurusan = allJurusanData[sesi] || [];
        jurusan.forEach((j, idx) => {
            const ctx = document.getElementById(`chartJurusan-${sesi}-${idx}`);
            if (ctx) makeDonut(ctx, j.data, ['Done', 'In Progress', 'Not Yet']);
        });
    }

    const dropdown = document.getElementById('sessionFilter');
    dropdown.addEventListener('change', (e) => {
        const selected = e.target.value;
        document.querySelectorAll('.session-section').forEach(s => s.style.display = 'none');
        document.querySelector(`.session-section[data-session="${selected}"]`).style.display = '';
        renderChartsForSession(selected);
    });

    renderChartsForSession('{{ $sessions->first() }}');
});
</script>
@endsection
