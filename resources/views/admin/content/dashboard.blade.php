{{-- menghubungkan file main --}}
@extends('admin.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Admin')

{{-- membuat content disini --}}
@section('content')
<main class="p-4 md:ml-64 h-auto pt-20 bg-re">

    <div class="p-4 mb-4 text-white rounded-lg bg-green-500" role="alert">
        <h3 class="text-lg font-bold italic">Welcome, {{auth()->user()->name}}</h3>
    </div>

    <!-- Chart Peserta -->
    <div class="w-full py-5 flex items-center gap-8 flex-wrap">
        @foreach($sessions as $sesi)
        <div class="bg-white p-4 rounded-lg w-full md:w-[30%] border-2 border-black">
            <h2 class="text-lg font-semibold mb-4 text-center">Session {{ $sesi }}</h2>
            <div class="flex justify-center">
                <canvas id="chartSession{{ $sesi }}" height="10" width="10"></canvas>
            </div>
            <div class="mt-4 flex justify-center gap-4 flex-wrap">
                @php
                $sessionData = $chartData[array_search($sesi, array_column($chartData, 'sesi'))];
                @endphp
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[rgba(0,255,111,0.7)] mr-2"></div>
                    <span>Done: {{round($sessionData['data']['Done']) }}</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[rgba(255,196,0,0.7)] mr-2"></div>
                    <span>Work: {{round($sessionData['data']['Work']) }}</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[rgba(255,0,0,0.7)] mr-2"></div>
                    <span>Not Yet: {{round($sessionData['data']['Not Yet']) }}</span>
                </div>
            </div>
            <div class="mx-auto font-bold w-44 mt-3">
                <span>Total Participant: {{round($sessionData['total'])}}</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Inisialisasi Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        // Warna untuk setiap status
        const colors = {
            'Done': 'rgba(0, 255, 111, 0.7)',
            'Work': 'rgba(255, 196, 0, 0.7)',
            'Not Yet': 'rgba(255, 0, 0, 0.7)'
        };

        // Buat chart untuk setiap sesi
        @json($chartData).forEach(session => {
            const ctx = document.getElementById(`chartSession${session.sesi}`);
            if (!ctx) return;

            const labels = ['Done', 'Work', 'Not Yet'];
            const dataValues = labels.map(label => session.data[label]);

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: labels.map(label => colors[label]),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    });
    </script>

</main>


@endsection