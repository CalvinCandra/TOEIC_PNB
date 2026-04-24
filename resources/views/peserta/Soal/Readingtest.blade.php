@extends('layouts.Soal.toeic')

@section('title', 'Reading Test - TOEIC')

@section('timer')
<div class="flex items-center gap-3">
    <div class="hidden sm:block text-slate-500 font-medium text-xs"><i class="fa-solid fa-book-open mr-1 text-slate-400"></i> Reading</div>
    <div class="bg-indigo-600 text-white font-mono font-bold tracking-widest px-3 py-1.5 rounded-lg shadow-sm flex items-center gap-2 tabular-nums text-sm">
        <i class="fa-regular fa-clock opacity-80"></i>
        <span id="countdown-nav">--:--:--</span>
    </div>
</div>
@endsection

{{-- @dd(session('waktu_akhir')) --}}

@section('content')

<form action="{{url('/ProsesJawabReading')}}" method="POST" id="toeic_form" class="space-y-6">
    @csrf
    <!-- Save id part -->
    <input type="hidden" name="id_part" value="{{ $part->id_part}}">

    <!-- Part Direction Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" id="petunjuk">
        {{-- header --}}
        <div class="bg-slate-50 border-b border-slate-200 p-4 flex items-center justify-between">
            <h1 class="text-[15px] font-bold text-slate-800 flex items-center gap-2">
                <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-md shadow-inner text-xs uppercase tracking-wider">{{$part->part}} Reading</span>
                Question {{$part->dari_nomor}} - {{$part->sampai_nomor}}
            </h1>
        </div>

        {{-- direction content --}}
        <div class="p-5 md:p-6">
            <div class="prose max-w-none text-slate-600 text-[14px] leading-relaxed mb-4">
                <p>{!! $part->petunjuk !!}</p>
            </div>

            {{-- media --}}
            <div class="flex flex-col gap-3">
                @if (!empty($part->id_gambar))
                <div class="border border-slate-100 rounded-xl p-2 bg-slate-50 self-start cursor-zoom-in group relative">
                    <img src="{{asset('storage/gambar/'.$part->gambar->gambar)}}" alt="gambar soal" class="zoomable-image max-h-64 object-contain rounded-lg">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-lg pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass-plus text-slate-700 bg-white/80 p-2 rounded-full shadow-sm"></i>
                    </div>
                </div>
                @endif
                @if (!empty($part->id_gambar_1))
                <div class="border border-slate-100 rounded-xl p-2 bg-slate-50 self-start cursor-zoom-in group relative">
                    <img src="{{asset('storage/gambar/'.$part->gambar->gambar1)}}" alt="gambar soal" class="zoomable-image max-h-64 object-contain rounded-lg">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-lg pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass-plus text-slate-700 bg-white/80 p-2 rounded-full shadow-sm"></i>
                    </div>
                </div>
                @endif
                @if (!empty($part->id_gambar_2))
                <div class="border border-slate-100 rounded-xl p-2 bg-slate-50 self-start cursor-zoom-in group relative">
                    <img src="{{asset('storage/gambar/'.$part->gambar->gambar2)}}" alt="gambar soal" class="zoomable-image max-h-64 object-contain rounded-lg">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-lg pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass-plus text-slate-700 bg-white/80 p-2 rounded-full shadow-sm"></i>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Multi Question --}}
    @if (!$part->multi_soal == NULL)
    <div class="bg-amber-50/50 rounded-2xl border border-amber-200 p-5 shadow-sm" id="multi">
        <h1 class="text-xs font-bold text-amber-800 uppercase tracking-widest mb-2 flex items-center gap-2">
            <i class="fa-solid fa-layer-group"></i> Multiple Questions: <span class="text-amber-600">{{$part->dari_nomor}} to {{$part->sampai_nomor}}</span>
        </h1>
        <div class="prose max-w-none text-amber-900 text-[14px] leading-relaxed">
            <p>{!! $part->multi_soal !!}</p>
        </div>
    </div>
    @endif

    <div class="space-y-4" id="soal">
        @foreach ($soalReading as $data)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
            <input type="hidden" name="id_soal[]" value="{{ $data->id_soal }}">

            <div class="p-5 md:p-6">
                
                {{-- passage text --}}
                @if(!empty($data->text))
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 md:p-5 mb-5 prose max-w-none prose-slate text-slate-800 leading-loose text-[14px]">
                    {!! $data->text !!}
                </div>
                @endif

                <div class="flex flex-col gap-5">
                    
                    {{-- Media Content --}}
                    <div class="w-full flex flex-col gap-3">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2 mb-1">
                            <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center shadow-inner">{{$data->nomor_soal}}</div>
                            Question
                        </h2>

                        @if (!empty($data->id_audio))
                            @if (!$audioPlayed)
                            <div class="bg-slate-50 rounded-xl p-2 border border-slate-100 sm:w-max">
                                <audio id="audio" controls controlsList="nodownload" class="max-w-full h-8 w-full">
                                    <source src="{{asset('storage/audio/'.$data->audio->audio)}}" type="audio/mp3">
                                </audio>
                            </div>
                            @else
                            <p class="text-[11px] text-slate-500 italic px-2"><i class="fa-solid fa-circle-info"></i> Audio has already played</p>
                            @endif
                        @else
                            {{-- Line separator only if no text above, otherwise it's clean enough --}}
                            @if(empty($data->text))<div class="w-full h-px bg-slate-100"></div>@endif
                        @endif

                        @if (!empty($data->id_gambar))
                        <div class="border border-slate-100 rounded-xl p-1.5 bg-slate-50 cursor-zoom-in group relative self-start">
                            <img src="{{asset('storage/gambar/'.$data->gambar->gambar)}}" alt="question image" class="zoomable-image max-h-64 object-contain rounded-lg w-full">
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-lg pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass-plus text-slate-700 bg-white/80 p-2 rounded-full shadow-sm"></i>
                            </div>
                        </div>
                        @endif
                        @if (!empty($data->id_gambar_1))
                        <div class="border border-slate-100 rounded-xl p-1.5 bg-slate-50 cursor-zoom-in group relative self-start">
                            <img src="{{asset('storage/gambar/'.$data->gambar1->gambar)}}" alt="question image" class="zoomable-image max-h-64 object-contain rounded-lg w-full">
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-lg pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass-plus text-slate-700 bg-white/80 p-2 rounded-full shadow-sm"></i>
                            </div>
                        </div>
                        @endif
                        @if (!empty($data->id_gambar_2))
                        <div class="border border-slate-100 rounded-xl p-1.5 bg-slate-50 cursor-zoom-in group relative self-start">
                            <img src="{{asset('storage/gambar/'.$data->gambar2->gambar)}}" alt="question image" class="zoomable-image max-h-64 object-contain rounded-lg w-full">
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-lg pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass-plus text-slate-700 bg-white/80 p-2 rounded-full shadow-sm"></i>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Question & Options Area --}}
                    <div class="flex-1">
                        @if(!empty($data->soal))
                        <div class="text-slate-800 font-medium text-[15px] leading-relaxed mb-4 p-3 bg-slate-50 rounded-xl border border-slate-100">{{$data->soal}}</div>
                        @endif

                        {{-- Options --}}
                        <div class="space-y-2">
                            @foreach (['a', 'b', 'c', 'd'] as $opt)
                                @php $jawabanKey = 'jawaban_' . $opt; @endphp
                                @if (!is_null($data->$jawabanKey))
                                <label for="option{{ strtoupper($opt) }}_{{ $data->id_soal }}" 
                                       class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-blue-50/50 hover:border-blue-300 transition-colors group has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500 relative">
                                    <div class="flex items-center h-5 mr-3 shrink-0">
                                        <input type="radio" 
                                               id="option{{ strtoupper($opt) }}_{{ $data->id_soal }}" 
                                               name="jawaban[{{ $data->id_soal }}]" 
                                               value="{{ strtoupper($opt) }}" 
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                    </div>
                                    <div class="text-slate-700 text-[14px] group-hover:text-slate-900 group-has-[:checked]:font-semibold select-none leading-snug w-full">
                                        {{ $data->$jawabanKey }}
                                    </div>
                                </label>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="pt-4 border-t border-slate-200 flex justify-end pb-8">
        @if ($part->tanda < count($GetAllPart)) 
            <button type="submit" name="tombol" value="next" id="nextButton"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl px-8 py-3.5 transition-all shadow-md active:scale-95 flex items-center gap-2 w-full sm:w-auto justify-center">
                Next Section <i class="fa-solid fa-arrow-right"></i>
            </button>
        @else
            <button type="submit" name="tombol" value="Submit" id="submitButton"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl px-8 py-3.5 transition-all shadow-md active:scale-95 flex items-center gap-2 w-full sm:w-auto justify-center">
                Submit Answers <i class="fa-solid fa-check"></i>
            </button>
        @endif
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- matiin fungsi back pada browser --}}
{{-- Timer Server-Sync: tidak bisa dimanipulasi via localStorage/DevTools --}}
<script>
(function () {
    const TYPE = 'reading';
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    const form = document.getElementById('toeic_form');

    let remainingSeconds = 0;
    let timerInterval = null;

    async function initTimer() {
        try {
            const res = await fetch(`/api/remaining-time/${TYPE}`, {
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                }
            });

            if (!res.ok) throw new Error('Server response tidak OK: ' + res.status);

            const data = await res.json();

            if (data.auto_submit || data.remaining <= 0) {
                autoSubmit();
                return;
            }

            remainingSeconds = data.remaining;
            startCountdown();

        } catch (e) {
            console.warn('[Timer] Gagal fetch dari server, fallback ke session waktu_akhir', e);
            fallbackToSessionTime();
        }
    }

    function startCountdown() {
        updateDisplay(remainingSeconds);

        if (timerInterval) clearInterval(timerInterval);

        timerInterval = setInterval(function () {
            remainingSeconds--;
            updateDisplay(remainingSeconds);

            if (remainingSeconds > 0 && remainingSeconds % 30 === 0) {
                syncWithServer();
            }

            if (remainingSeconds <= 0) {
                clearInterval(timerInterval);
                autoSubmit();
            }
        }, 1000);
    }

    async function syncWithServer() {
        try {
            const res = await fetch(`/api/remaining-time/${TYPE}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.auto_submit || data.remaining <= 0) {
                clearInterval(timerInterval);
                autoSubmit();
                return;
            }

            if (Math.abs(remainingSeconds - data.remaining) > 5) {
                console.warn('[Timer] Selisih terdeteksi, koreksi dari server:', data.remaining);
                remainingSeconds = data.remaining;
            }

        } catch (e) {
            console.warn('[Timer] Sync ke server gagal, timer lokal tetap jalan', e);
        }
    }

    function fallbackToSessionTime() {
        const endAccessTime = "{{ session('waktu_akhir') ?? '' }}";
        if (!endAccessTime) {
            console.error('[Timer] Tidak ada waktu_akhir di session dan API gagal');
            return;
        }

        const accessLimit = new Date(endAccessTime).getTime();
        const remaining = Math.floor((accessLimit - Date.now()) / 1000);

        if (remaining <= 0) {
            autoSubmit();
            return;
        }

        remainingSeconds = remaining;
        startCountdown();
    }

    function updateDisplay(seconds) {
        if (seconds < 0) seconds = 0;

        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;

        const display = `${pad(h)} h : ${pad(m)} m : ${pad(s)} s`;
        const elNav = document.getElementById('countdown-nav');
        if (elNav) elNav.textContent = display;

        if (seconds <= 300 && elNav) elNav.classList.add('bg-red-600');
    }

    function pad(num) {
        return String(num).padStart(2, '0');
    }

    function autoSubmit() {
        const elNav = document.getElementById('countdown-nav');
        if (elNav) elNav.textContent = 'Time Out';

        const overlay = document.getElementById('overlay');
        if (overlay) overlay.style.display = 'flex';

        if (form) form.submit();
    }

    document.addEventListener('DOMContentLoaded', initTimer);
})();
</script>

<script>
    // Tambahkan juga handler untuk tombol Submit agar tidak terjadi double submit
    const submitButton = document.getElementById("submitButton");
    if (submitButton) {
        submitButton.addEventListener("click", function () {
            if (!formSubmitted) {
                formSubmitted = true;
                clearInterval(window.x);
            } else {
                event.preventDefault(); // Cegah submit jika sudah pernah submit
            }
        });
    }
</script>

<script>
    // menghentikan countdown ketika tombol submit ditekan
        document.getElementById("submitButton").addEventListener("click", function() {
            clearInterval(window.x);
        });
</script>
@endsection