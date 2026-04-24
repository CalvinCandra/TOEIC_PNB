<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')
    @include('layouts.header')

    <title>Test Result - TOEIC PNB</title>

    <!-- Tailwind & Flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <!-- Anti-Back di halaman Result: push state awal -->
    <script>
        (function () {
            history.pushState(null, "", location.href);
            history.pushState(null, "", location.href);
        })();
    </script>
</head>

<body class="bg-[#f8fafc] font-['Poppins'] text-slate-800 min-h-screen">

    {{-- header --}}
    <div class="mx-auto w-full max-w-5xl px-4 pt-8 md:pt-12 pb-6 relative z-50">
        <div class="bg-white rounded-3xl p-6 md:p-8 flex flex-col shadow-sm border border-slate-100 justify-center">
            <div class="text-center md:text-left">
                <p class="text-xl text-slate-500 font-medium">Hello, <span class="font-bold text-slate-800">{{ $peserta->nama_peserta }}</span> 👋</p>
                <h1 class="mt-2 font-extrabold text-2xl md:text-3xl text-slate-800">Your TOEIC Simulation Results</h1>
                <p class="text-slate-500 mt-2 text-sm">See the scores and results you've obtained in Starting TOEIC test.</p>
            </div>
            <div class="bg-amber-50 text-amber-700 px-4 py-3 rounded-xl border border-amber-100 flex items-center gap-3 w-max mt-5 self-center md:self-start">
                <i class="fa-solid fa-circle-info text-amber-500 text-lg"></i>
                <p class="font-medium text-xs leading-relaxed max-w-[300px]"><span class="font-bold">Note:</span> The test results are not a certificate.</p>
            </div>
        </div>
    </div>

    <!-- Score -->
    <div class="px-4 mx-auto w-full max-w-5xl relative z-50">
        <div class="flex flex-col md:flex-row gap-6 items-stretch">
            {{-- TOTAL SCORE --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-3xl shadow-md md:w-[35%] flex flex-col items-center justify-center p-8 relative overflow-hidden shrink-0">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-40 h-40 rounded-full bg-white opacity-10"></div>
                
                <h5 class="text-blue-100 font-bold tracking-widest text-sm uppercase mb-3 relative z-10 text-center">Total Score</h5>
                <p class="font-black text-7xl md:text-[5rem] relative z-10 leading-none drop-shadow-md">{{ $totalSkor }}</p>
            </div>

            {{-- LISTENING AND READING SCORE --}}
            <div class="flex-grow bg-white border border-slate-100 rounded-3xl shadow-sm md:w-[65%] p-6 md:p-8 flex flex-col justify-center">
                <!-- Listening Score -->
                <div class="mb-8">
                    <div class="flex justify-between items-end mb-3">
                        <span class="font-bold text-sm tracking-wide text-slate-700 uppercase flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shadow-sm"><i class="fa-solid fa-headphones text-lg"></i></div> 
                            Listening
                        </span>
                        <span id="score-1" class="font-extrabold text-2xl text-slate-800">0</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-slate-100 h-3.5 flex-grow rounded-full overflow-hidden shadow-inner relative">
                            <div id="progress-bar-1" class="bg-gradient-to-r from-indigo-500 to-blue-500 h-full rounded-full transition-all duration-[1500ms] ease-out w-0 relative">
                                <div class="absolute inset-0 bg-white/20"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reading Score -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <span class="font-bold text-sm tracking-wide text-slate-700 uppercase flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-sm"><i class="fa-solid fa-book-open text-lg"></i></div> 
                            Reading
                        </span>
                        <span id="score-2" class="font-extrabold text-2xl text-slate-800">0</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-slate-100 h-3.5 flex-grow rounded-full overflow-hidden shadow-inner relative">
                            <div id="progress-bar-2" class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-[1500ms] ease-out w-0 relative">
                                <div class="absolute inset-0 bg-white/20"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Description -->
    <div class="px-4 mt-6 mx-auto w-full max-w-5xl relative z-50">
        <div class="flex flex-col md:flex-row gap-6 items-stretch">
            {{-- YOUR RESULT --}}
            <div class="md:w-[35%] flex flex-col gap-4 shrink-0">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 pb-8 flex flex-col justify-center items-center text-center h-full min-h-[250px]">
                    <p class="font-bold text-slate-400 uppercase tracking-widest text-[11px] mb-4">Your Result</p>
                    <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-5 shadow-inner border border-blue-100">
                        <i class="fa-solid fa-award text-5xl drop-shadow-sm"></i>
                    </div>
                    <p class="text-xl font-extrabold text-slate-800 px-2 leading-tight">{{ $kategori }}</p>
                </div>
            </div>

            {{-- AN EXPLANATION --}}
            <div class="flex-grow bg-white border border-slate-100 rounded-3xl shadow-sm md:w-[65%] p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-[11px] tracking-widest uppercase text-slate-400 mb-2">An Explanation of Your Nature</h2>
                    <h3 class="font-bold text-2xl text-slate-800">{{ $kategori }}</h3>
                    <p class="font-semibold text-xs mt-2 text-indigo-700 bg-indigo-50 w-max px-3 py-1.5 rounded-lg border border-indigo-100">TOEIC score range of {{ $rangeSkor }}</p>
                    <div class="w-full bg-slate-100 h-px mt-5 mb-5 block"></div>
                    <p class="text-slate-600 leading-relaxed text-[15px] md:text-[14px] text-justify">{{ $detail }}</p>
                </div>
                
                <div class="mt-8 pt-6 border-t border-slate-50 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ url('/download-result') }}" target="_blank"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-all font-bold shadow-sm w-full active:scale-95">
                        <i class="fa-solid fa-file-pdf text-red-500"></i> Download PDF
                    </a>
                    <a href="{{ url('/destory') }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-all font-bold shadow-md hover:shadow-blue-600/30 w-full active:scale-95">
                        Back to Dashboard <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Result Categories -->
    <div class="px-4 mt-6 pb-16 mx-auto w-full max-w-5xl relative z-50">
        <div class="bg-white border border-slate-100 rounded-3xl shadow-sm p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center border border-slate-100 shadow-sm">
                    <i class="fa-solid fa-list text-lg"></i>
                </div>
                <h3 class="font-bold text-lg md:text-xl text-slate-800">Other Result Categories</h3>
            </div>

            <div id="accordion-flush" data-accordion="collapse"
                data-active-classes="bg-slate-50 text-blue-700"
                data-inactive-classes="text-slate-600" class="border border-slate-200 rounded-2xl overflow-hidden divide-y divide-slate-100">

                <!-- Proficient user - Effective Operational Proficiency C1 -->
                <h2 id="accordion-flush-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 md:p-5 font-medium rtl:text-right transition-colors focus:ring-0 gap-3 hover:bg-slate-50"
                        data-accordion-target="#accordion-flush-body-1" aria-expanded="false"
                        aria-controls="accordion-flush-body-1">
                        <div class="text-left flex flex-col md:flex-row md:items-center gap-1 md:gap-3">
                            <p class="text-base md:text-[15px] font-bold text-inherit">Proficient user - Effective Operational Proficiency C1</p>
                            <span class="text-xs bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-md border border-emerald-100 font-bold w-max">Range: 945 - 990</span>
                        </div>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                    <div class="p-4 md:p-5 pt-0 text-[13px] md:text-[14px] text-slate-500 leading-relaxed text-justify bg-slate-50/50">
                        Can understand a wide range of demanding, longer texts, and recognise implicit meaning. Can express him/ herself fluently and spontaneously without much obvious searching for expressions. Can use language flexibly and effectively for social, academic and professional purposes. Can produce clear, well-structured, detailed text on complex subjects, showing controlled use of organisational patterns, connectors and cohesive devices.
                    </div>
                </div>

                <!-- Independent user - Vantage B2 -->
                <h2 id="accordion-flush-heading-2">
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 md:p-5 font-medium rtl:text-right transition-colors focus:ring-0 gap-3 hover:bg-slate-50"
                        data-accordion-target="#accordion-flush-body-2" aria-expanded="false"
                        aria-controls="accordion-flush-body-2">
                        <div class="text-left flex flex-col md:flex-row md:items-center gap-1 md:gap-3">
                            <p class="text-base md:text-[15px] font-bold text-inherit">Independent user - Vantage B2</p>
                            <span class="text-xs bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-md border border-emerald-100 font-bold w-max">Range: 785 - 940</span>
                        </div>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                    <div class="p-4 md:p-5 pt-0 text-[13px] md:text-[14px] text-slate-500 leading-relaxed text-justify bg-slate-50/50">
                        Can understand the main ideas of complex text on both concrete and abstract topics, including technical discussions in his/her field of specialisation. Can interact with a degree of fluency and spontaneity that makes regular interaction with native speakers quite possible without strain for either party. Can produce clear, detailed text on a wide range of subjects and explain a viewpoint on a topical issue giving the advantages and disadvantages of various options.
                    </div>
                </div>

                <!-- Independent user - Threshold B1 -->
                <h2 id="accordion-flush-heading-3">
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 md:p-5 font-medium rtl:text-right transition-colors focus:ring-0 gap-3 hover:bg-slate-50"
                        data-accordion-target="#accordion-flush-body-3" aria-expanded="false"
                        aria-controls="accordion-flush-body-3">
                        <div class="text-left flex flex-col md:flex-row md:items-center gap-1 md:gap-3">
                            <p class="text-base md:text-[15px] font-bold text-inherit">Independent user - Threshold B1</p>
                            <span class="text-xs bg-amber-50 text-amber-600 px-2 py-0.5 rounded-md border border-amber-100 font-bold w-max">Range: 550 - 780</span>
                        </div>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                    <div class="p-4 md:p-5 pt-0 text-[13px] md:text-[14px] text-slate-500 leading-relaxed text-justify bg-slate-50/50">
                        Can understand the main points of clear standard input on familiar matters regularly encountered in work, school, leisure, etc. Can deal with most situations likely to arise whilst travelling in an area where the language is spoken. Can produce simple connected text on topics which are familiar or of personal interest. Can describe experiences and events, dreams, hopes and ambitions and briefly give reasons and explanations for opinions and plans.
                    </div>
                </div>

                <!-- Basic user - Waystage A2 -->
                <h2 id="accordion-flush-heading-4">
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 md:p-5 font-medium rtl:text-right transition-colors focus:ring-0 gap-3 hover:bg-slate-50"
                        data-accordion-target="#accordion-flush-body-4" aria-expanded="false"
                        aria-controls="accordion-flush-body-4">
                        <div class="text-left flex flex-col md:flex-row md:items-center gap-1 md:gap-3">
                            <p class="text-base md:text-[15px] font-bold text-inherit">Basic user - Waystage A2</p>
                            <span class="text-xs bg-orange-50 text-orange-600 px-2 py-0.5 rounded-md border border-orange-100 font-bold w-max">Range: 225 - 545</span>
                        </div>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-4" class="hidden" aria-labelledby="accordion-flush-heading-4">
                    <div class="p-4 md:p-5 pt-0 text-[13px] md:text-[14px] text-slate-500 leading-relaxed text-justify bg-slate-50/50">
                        Can understand sentences and frequently used expressions related to areas of most immediate relevance (e.g. very basic personal and family information, shopping, local geography, employment). Can communicate in simple and routine tasks requiring a simple and direct exchange of information on familiar and routine matters. Can describe in simple terms aspects of his/her background, immediate environment and matters in areas of immediate need.
                    </div>
                </div>

                <!-- Basic user - Breakthrough A1 -->
                <h2 id="accordion-flush-heading-5">
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 md:p-5 font-medium rtl:text-right transition-colors focus:ring-0 gap-3 hover:bg-slate-50"
                        data-accordion-target="#accordion-flush-body-5" aria-expanded="false"
                        aria-controls="accordion-flush-body-5">
                        <div class="text-left flex flex-col md:flex-row md:items-center gap-1 md:gap-3">
                            <p class="text-base md:text-[15px] font-bold text-inherit">Basic user - Breakthrough A1</p>
                            <span class="text-xs bg-red-50 text-red-600 px-2 py-0.5 rounded-md border border-red-100 font-bold w-max">Range: 0 - 220</span>
                        </div>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-5" class="hidden" aria-labelledby="accordion-flush-heading-5">
                    <div class="p-4 md:p-5 pt-0 text-[13px] md:text-[14px] text-slate-500 leading-relaxed text-justify bg-slate-50/50">
                        Can understand and use familiar everyday expressions and very basic phrases aimed at the satisfaction of needs of a concrete type. Can introduce him/herself and others and can ask and answer questions about personal details such as where he/she lives, people he/she knows and things he/she has. Can interact in a simple way provided the other person talks slowly and clearly and is prepared to help.
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- javascript for persentase --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                function updateProgressBar(score, maxScore, progressBarId, scoreId) {
                    const percentage = (score / maxScore) * 100;
                    document.getElementById(progressBarId).style.width = percentage + '%';
                    
                    // Count up animation for score text
                    let current = 0;
                    const increment = score / 50; 
                    const counter = setInterval(() => {
                        current += increment;
                        if (current >= score) {
                            document.getElementById(scoreId).innerText = score;
                            clearInterval(counter);
                        } else {
                            document.getElementById(scoreId).innerText = Math.floor(current);
                        }
                    }, 20);
                }

                // Update progress bar listening
                const score1 = {{ $skorListening }};
                const maxScore1 = 495;
                updateProgressBar(score1, maxScore1, 'progress-bar-1', 'score-1');

                // Update progress bar reading
                const score2 = {{ $skorReading }};
                const maxScore2 = 495;
                updateProgressBar(score2, maxScore2, 'progress-bar-2', 'score-2');
            }, 300);
        });
    </script>

    <!-- Anti-Back Handler di halaman Result -->
    <script>
        (function () {
            "use strict";

            document.addEventListener("DOMContentLoaded", function () {
                history.pushState(null, "", location.href);
                history.pushState(null, "", location.href);
            });

            window.addEventListener("popstate", function () {
                window.location.replace("/peserta");
            });

            document.addEventListener("keydown", function (e) {
                if ((e.altKey && e.key === "ArrowLeft") || e.key === "BrowserBack") {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.replace("/peserta");
                }
            });

            document.addEventListener("DOMContentLoaded", function () {
                const dashboardLink = document.querySelector('a[href="/destory"]');
                if (dashboardLink) {
                    dashboardLink.addEventListener("click", function (e) {
                        e.preventDefault();
                        window.location.replace("/peserta");
                    });
                }
            });
        })();
    </script>

</body>

</html>