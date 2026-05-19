@extends('peserta.main')
@section('Title', $part->part . ' | Result')

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
                <h1 class="text-2xl sm:text-3xl font-bold">{{ $part->part }}</h1>
                <p class="mt-2 opacity-90">{{ $bank->bank }} — {{ $part->kategori }}</p>
            </div>
            <div class="absolute right-4 top-4 opacity-20">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C20.168 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="currentColor" stroke-width="1" fill="none"/>
                </svg>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-6">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">First Score</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $chartData['first'] }}%</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Best Score</div>
                <div class="text-2xl font-bold text-green-500 mt-1">{{ $chartData['best'] }}%</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Last Score</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $chartData['last'] }}%</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Average</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $chartData['avg'] }}%</div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wider">Attempts</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $chartData['total'] }}</div>
            </div>
        </div>

        {{-- Chart Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Score Progress</h2>
                <div class="relative" style="height: 300px;">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/SelfStudy/Bank/{{ $bank->id_bank }}/Part/{{ $part->token_part }}"
               class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                <i class="fa-solid fa-rotate-right me-1"></i> Try Again
            </a>
            <a href="/SelfStudy/Bank/{{ $bank->id_bank }}"
               class="flex-1 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-lg font-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Parts
            </a>
        </div>
    </section>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('progressChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Score',
                data: @json($chartData['data']),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.3, fill: true, pointRadius: 5, pointHoverRadius: 8,
                pointBackgroundColor: 'rgb(59, 130, 246)',
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
                    title: { display: true, text: 'Score (%)' }
                },
                x: { title: { display: true, text: 'Attempt' } }
            },
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: (ctx) => `Score: ${ctx.parsed.y}%` } }
            }
        }
    });
</script>
