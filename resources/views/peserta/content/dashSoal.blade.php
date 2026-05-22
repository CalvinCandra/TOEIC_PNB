{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman dimana --}}
@section('Title', 'Take Try Out')

{{-- membuat content dimana --}}
@section('content')

@if (session('error'))
<div class="fixed top-24 right-5 z-50 animate-fade-in-down">
    <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-xl"></i>
        <div>
            <h4 class="font-bold text-sm">Error</h4>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-400 hover:text-red-600">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@endif

<main class="p-5 md:ml-64 md:px-8 lg:px-12 h-auto pt-20">

    <div class="my-6 max-w-5xl mx-auto">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-900">Select Assessment</h1>
            <p class="text-gray-500 mt-1 text-xs max-w-2xl">Choose the simulation type you want to take. Ensure you have your test code ready before starting the timed simulator.</p>
        </div>

        @php
            $toeicEnabled     = \App\Models\FeatureToggle::isEnabled('toeic_simulation');
            $selfStudyEnabled = \App\Models\FeatureToggle::isEnabled('self_study');
        @endphp

        {{-- Grid 2 card --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- ── Card 1: TOEIC Simulation (toggle-aware) ── --}}
            @if($toeicEnabled)
            <a data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                class="group flex flex-col bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300 cursor-pointer overflow-hidden relative">
                
                <div class="h-36 w-full overflow-hidden relative bg-slate-100">
                    <img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500"
                        src="{{ asset('img/English.png') }}" alt="TOEIC Try Out" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-3 left-4">
                        <span class="bg-blue-600/90 backdrop-blur-md text-white text-[9px] font-bold px-2 py-1 rounded-full uppercase tracking-widest shadow-sm">Timed Test</span>
                    </div>
                </div>

                <div class="flex flex-col p-5 flex-1">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 group-hover:text-blue-600 transition-colors">TOEIC Simulation</h5>
                    <div class="mb-4 space-y-3">
                        <p class="text-xs text-gray-500 leading-relaxed">
                            A highly accurate Try Out specifically designed to prepare and enhance English language skills for the real TOEIC exam.
                        </p>
                        <div class="bg-blue-50/50 rounded-xl p-3 border border-blue-100/50">
                            <h6 class="text-[10px] font-bold text-blue-900 uppercase tracking-widest mb-1.5"><i class="fa-regular fa-clock mr-1"></i> Time Allocation (120 Mins)</h6>
                            <ul class="text-xs text-blue-800/80 space-y-0.5 ml-1 list-inside list-disc font-medium">
                                <li>45 minutes for Listening Section</li>
                                <li>75 minutes for Reading Section</li>
                            </ul>
                        </div>
                        <p class="text-[11px] text-amber-700 bg-amber-50 border border-amber-100 px-3 py-2 rounded-xl font-medium leading-relaxed">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500 mr-1"></i> Time management is critical. Answers will be submitted automatically once the 120 minutes are over.
                        </p>
                    </div>
                    
                    <div class="mt-auto pt-1 flex justify-end">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-blue-600 group-hover:bg-blue-600 group-hover:text-white px-4 py-2 rounded-lg transition-all duration-300">
                            Start Try Out <i class="fa-solid fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </a>
            @else
            <div class="flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden relative select-none">

                {{-- Unavailable banner --}}
                <div class="h-36 w-full overflow-hidden relative bg-slate-100">
                    <img class="object-cover w-full h-full opacity-25 grayscale"
                        src="{{ asset('img/English.png') }}" alt="TOEIC Try Out" />
                    <div class="absolute inset-0 bg-slate-900/55"></div>

                    {{-- Lock icon centred --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                        <div class="w-11 h-11 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                            <i class="fa-solid fa-lock text-white text-lg"></i>
                        </div>
                        <span class="text-white/70 text-[10px] font-semibold tracking-widest uppercase">Session Closed</span>
                    </div>

                    {{-- Top-right badge --}}
                    <div class="absolute top-3 right-3">
                        <span class="bg-slate-800/75 backdrop-blur-md text-white/85 text-[9px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm flex items-center gap-1">
                            <i class="fa-solid fa-circle-xmark text-red-400 text-[10px]"></i> Disabled
                        </span>
                    </div>
                </div>

                {{-- Card body --}}
                <div class="flex flex-col p-5 flex-1">
                    <h5 class="mb-1.5 text-lg font-bold tracking-tight text-slate-400">TOEIC Simulation</h5>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        A highly accurate Try Out specifically designed to prepare and enhance English language skills for the real TOEIC exam.
                    </p>

                    {{-- Info notice --}}
                    <div class="mt-auto flex items-start gap-2.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-3">
                        <i class="fa-solid fa-circle-info text-slate-400 mt-0.5 shrink-0 text-sm"></i>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            This feature is currently <strong class="text-slate-600">not available</strong>. Please wait for your exam supervisor to open the session.
                        </p>
                    </div>
                </div>
            </div>
            @endif


            {{-- ── Card 2: Self Study (toggle-aware) ── --}}
            @if($selfStudyEnabled)
            <a href="/SelfStudy"
               class="group flex flex-col bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-300 cursor-pointer overflow-hidden relative">
                
                <div class="h-36 w-full overflow-hidden relative bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950">
                    <div class="absolute inset-0 flex items-center justify-center opacity-25">
                        <i class="fa-solid fa-person-chalkboard text-7xl text-white drop-shadow-sm"></i>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-3 left-4">
                        <span class="bg-blue-600/95 backdrop-blur-md text-white text-[9px] font-bold px-2 py-1 rounded-full uppercase tracking-widest shadow-sm">Practice Mode</span>
                    </div>
                </div>

                <div class="flex flex-col p-5 flex-1">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 group-hover:text-indigo-600 transition-colors">Self Study</h5>
                    <div class="mb-4 space-y-3">
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Master every section of the TOEIC test at your own pace. Practice questions with unlimited audio replay and review detailed answers to continuously improve.
                        </p>
                        <div class="bg-indigo-50/40 rounded-xl p-3 border border-indigo-100/50">
                            <h6 class="text-[10px] font-bold text-indigo-900 uppercase tracking-widest mb-1.5"><i class="fa-regular fa-lightbulb mr-1"></i> Key Features</h6>
                            <ul class="text-xs text-indigo-850 space-y-0.5 ml-1 list-inside list-disc font-medium">
                                <li>No time limit per section</li>
                                <li>Unlimited audio instruction replay</li>
                                <li>Detailed correct/incorrect analysis</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-1 flex justify-end">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white px-4 py-2 rounded-lg transition-all duration-300">
                            Start Practice <i class="fa-solid fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </a>
            @else
            {{-- Self Study Disabled / Coming Soon --}}
            <div class="flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden relative select-none">

                {{-- Unavailable banner --}}
                <div class="h-36 w-full overflow-hidden relative bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950">
                    <div class="absolute inset-0 flex items-center justify-center opacity-10">
                        <i class="fa-solid fa-person-chalkboard text-7xl text-white drop-shadow-sm"></i>
                    </div>
                    <div class="absolute inset-0 bg-slate-900/60"></div>

                    {{-- Lock icon centred --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                        <div class="w-11 h-11 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                            <i class="fa-solid fa-clock text-white text-lg"></i>
                        </div>
                        <span class="text-white/70 text-[10px] font-semibold tracking-widest uppercase">Coming Soon</span>
                    </div>

                    {{-- Top-right badge --}}
                    <div class="absolute top-3 right-3">
                        <span class="bg-slate-800/75 backdrop-blur-md text-white/85 text-[9px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm flex items-center gap-1">
                            <i class="fa-solid fa-circle-xmark text-red-400 text-[10px]"></i> Disabled
                        </span>
                    </div>
                </div>

                {{-- Card body --}}
                <div class="flex flex-col p-5 flex-1">
                    <h5 class="mb-1.5 text-lg font-bold tracking-tight text-slate-400">Self Study</h5>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        Master every section of the TOEIC test at your own pace. Practice questions with unlimited audio replay and review detailed answers.
                    </p>

                    {{-- Info notice --}}
                    <div class="mt-auto flex items-start gap-2.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-3">
                        <i class="fa-solid fa-circle-info text-slate-400 mt-0.5 shrink-0 text-sm"></i>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            This feature is currently <strong class="text-slate-600">not available</strong>. Please wait for your exam supervisor to open the session.
                        </p>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</main>

{{-- Modal input kode soal --}}
<div id="authentication-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[1000] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-sm max-h-full">
        <div class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform scale-95 transition-transform duration-300" id="modal-container-scale">

            {{-- Modal header --}}
            <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-gray-900">Enter Test Code</h3>
                <button type="button"
                    class="text-gray-400 bg-white hover:bg-slate-100 hover:text-gray-900 rounded-full text-sm w-8 h-8 flex justify-center items-center shadow-sm border border-slate-200 transition-colors"
                    data-modal-hide="authentication-modal">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="p-6">
                <form class="space-y-6" action="{{ url('/TokenQuestion') }}">
                    <div>
                        <label for="token" class="block mb-2 text-sm font-semibold text-gray-800">Token / Code Access</label>
                        <input type="text" name="bankSoal" id="token"
                            class="bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 transition-colors placeholder-gray-400"
                            placeholder="e.g. TOEIC2026" required />
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-lg shadow-blue-600/20">
                        Let's Start <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Disable back button --}}
<script>
    history.pushState(null, document.title, location.href);
    window.addEventListener('popstate', function (event) {
        history.pushState(null, document.title, location.href);
    });

    // Custom flowbite modal animation touch up
    const modalTrigger = document.querySelector('[data-modal-target="authentication-modal"]');
    const modalContainer = document.getElementById('modal-container-scale');
    if(modalTrigger && modalContainer) {
        modalTrigger.addEventListener('click', () => {
            setTimeout(() => {
                modalContainer.classList.remove('scale-95');
                modalContainer.classList.add('scale-100');
            }, 10);
        });
    }
    const modalHide = document.querySelector('[data-modal-hide="authentication-modal"]');
    if(modalHide && modalContainer) {
        modalHide.addEventListener('click', () => {
            modalContainer.classList.remove('scale-100');
            modalContainer.classList.add('scale-95');
        });
    }
</script>

@endsection
