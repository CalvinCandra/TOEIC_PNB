@extends('landing.main')

@section('Title', 'TOEIC Assessment — Politeknik Negeri Bali')

@section('content')

{{-- ══════════════════════════════════════════════════════
     HERO SECTION
═════════════════════════════════════════════════════ --}}
<section class="bg-blue-950 pt-28 pb-16 px-4 lg:px-8 min-h-screen flex items-center" id="home">
    <div class="max-w-screen-xl mx-auto w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- Teks --}}
            <div>
                <span class="inline-block bg-blue-950/10 text-blue-300 text-xs font-semibold px-3 py-1 rounded-full mb-4 tracking-widest uppercase">
                    Politeknik Negeri Bali
                </span>
                <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight mb-5">
                    Try the <span class="text-blue-300">TOEIC</span><br>Test Simulation
                </h1>
                <p class="text-slate-400 text-base leading-relaxed mb-8 max-w-md">
                    Improve your English proficiency score easily and effectively. Practice with real exam-style questions anytime, anywhere.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ url('/DashboardSoal') }}"
                        class="inline-flex items-center gap-2 bg-[#FB8500] hover:bg-[#e07600] text-white font-semibold px-6 py-3 rounded-xl transition-colors no-underline">
                        Start Now
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#about"
                        class="inline-flex items-center gap-2 border border-slate-600 hover:border-slate-400 text-slate-300 hover:text-white font-medium px-6 py-3 rounded-xl transition-colors no-underline">
                        Learn More
                    </a>
                </div>
            </div>

            {{-- Gambar --}}
            <div class="hidden lg:flex justify-center">
                <img src="{{ asset('img/hero.png') }}" alt="TOEIC Simulation"
                    class="w-full max-w-md object-contain drop-shadow-xl" loading="lazy" />
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     ABOUT SECTION
═════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 px-4 lg:px-8" id="about">
    <div class="max-w-screen-xl mx-auto">

        <div class="mb-12">
            <span class="text-xs font-semibold text-blue-950 uppercase tracking-widest">About</span>
            <h2 class="text-3xl font-bold text-slate-900 mt-2 mb-4">What is TOEIC?</h2>
            <p class="text-slate-600 text-base leading-relaxed max-w-2xl">
                TOEIC (Test of English for International Communication) is a standardized test that measures English language proficiency in a workplace context, recognized globally by thousands of organizations.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-5 mb-14">
            <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100">
                <div class="text-3xl font-bold text-blue-950">200</div>
                <div class="text-sm text-slate-500 mt-1">Questions per test</div>
            </div>
            <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100">
                <div class="text-3xl font-bold text-blue-950">990</div>
                <div class="text-sm text-slate-500 mt-1">Maximum score</div>
            </div>
            <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100">
                <div class="text-3xl font-bold text-blue-950">120</div>
                <div class="text-sm text-slate-500 mt-1">Minutes duration</div>
            </div>
        </div>

        {{-- Why TOEIC --}}
        <span class="text-xs font-semibold text-blue-950 uppercase tracking-widest">Why is TOEIC Important?</span>
        <h3 class="text-2xl font-bold text-slate-900 mt-2 mb-8">Benefits of Taking TOEIC</h3>

        {{-- Benefits Grid Desktop --}}
        <div class="hidden lg:grid grid-cols-4 gap-5">
            <div class="border border-slate-100 rounded-2xl p-6 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <img src="{{ asset('img/benefit 1.png') }}" alt="Industry Standard"
                    class="w-20 h-20 object-contain mx-auto mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-sm mb-1">Industry Requirements Standard</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Recognized by 14,000+ companies worldwide</p>
            </div>
            <div class="border border-slate-100 rounded-2xl p-6 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <img src="{{ asset('img/benefit 2.png') }}" alt="Self-Confidence"
                    class="w-20 h-20 object-contain mx-auto mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-sm mb-1">Self-Confidence Booster</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Build confidence in English communication</p>
            </div>
            <div class="border border-slate-100 rounded-2xl p-6 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <img src="{{ asset('img/benefit 3.png') }}" alt="English Skills"
                    class="w-20 h-20 object-contain mx-auto mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-sm mb-1">Improve Your English Skills</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Sharpen listening and reading abilities</p>
            </div>
            <div class="border border-slate-100 rounded-2xl p-6 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <img src="{{ asset('img/benefit 4.png') }}" alt="Communication"
                    class="w-20 h-20 object-contain mx-auto mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-sm mb-1">Improve Communication Skill</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Develop professional English communication</p>
            </div>
        </div>

        {{-- Benefits Carousel Mobile --}}
        <div class="lg:hidden" id="benefits-carousel" data-carousel="slide">
            <div class="relative overflow-hidden rounded-2xl">
                <div class="duration-700 ease-in-out" data-carousel-item>
                    <div class="border border-slate-100 rounded-2xl p-6 text-center">
                        <img src="{{ asset('img/benefit 1.png') }}" alt="Industry Standard"
                            class="w-20 h-20 object-contain mx-auto mb-4" loading="lazy" />
                        <h4 class="font-semibold text-slate-800 text-sm mb-1">Industry Requirements Standard</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Recognized by 14,000+ companies worldwide</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     TEST COVERAGE SECTION
═════════════════════════════════════════════════════ --}}
<section class="bg-blue-950 py-20 px-4 lg:px-8">
    <div class="max-w-screen-xl mx-auto">

        <div class="mb-10">
            <span class="text-xs font-semibold text-blue-300 uppercase tracking-widest">Test Coverage</span>
            <h2 class="text-3xl font-bold text-white mt-2">TOEIC Simulation Test Coverage</h2>
        </div>

        {{-- Coverage Cards --}}
        <div class="grid md:grid-cols-2 gap-5 mb-8">
            <div class="bg-blue-900 rounded-2xl p-6 border-l-4 border-blue-950">
                <h3 class="text-lg font-semibold text-white mb-4">
                    <i class="fa-solid fa-headphones mr-2 text-blue-300"></i>Listening Section
                </h3>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-slate-400 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300 flex-shrink-0"></span></span>
                        100 questions
                    </li>
                    <li class="flex items-center gap-2 text-slate-400 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300 flex-shrink-0"></span></span>
                        45 minutes
                    </li>
                    <li class="flex items-center gap-2 text-slate-400 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300 flex-shrink-0"></span></span>
                        Part 1–4: Photographs, Q&R, Conversations, Talks
                    </li>
                </ul>
            </div>
            <div class="bg-blue-900 rounded-2xl p-6 border-l-4 border-[#FB8500]">
                <h3 class="text-lg font-semibold text-white mb-4">
                    <i class="fa-solid fa-book-open mr-2 text-[#FB8500]"></i>Reading Section
                </h3>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-slate-400 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FB8500] flex-shrink-0"></span>
                        100 questions
                    </li>
                    <li class="flex items-center gap-2 text-slate-400 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FB8500] flex-shrink-0"></span>
                        75 minutes
                    </li>
                    <li class="flex items-center gap-2 text-slate-400 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FB8500] flex-shrink-0"></span>
                        Part 5–7: Incomplete Sentences, Text Completion, Passages
                    </li>
                </ul>
            </div>
        </div>

        {{-- Steps --}}
        <div class="bg-blue-900 rounded-2xl overflow-hidden">
            <div class="grid md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-[#0c2d4a]">
                <div class="p-6 text-center">
                    <div class="w-9 h-9 rounded-full bg-blue-950 flex items-center justify-center mx-auto mb-3">
                        <img src="{{ asset('favicon/form.png') }}" alt="step1" class="w-5 h-5 object-contain" loading="lazy" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">Follow Test Rules</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Understand and follow all exam regulations before starting</p>
                </div>
                <div class="p-6 text-center">
                    <div class="w-9 h-9 rounded-full bg-blue-950 flex items-center justify-center mx-auto mb-3">
                        <img src="{{ asset('favicon/create.png') }}" alt="step2" class="w-5 h-5 object-contain" loading="lazy" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">Work the Test</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Complete the Listening and Reading sections</p>
                </div>
                <div class="p-6 text-center">
                    <div class="w-9 h-9 rounded-full bg-blue-950 flex items-center justify-center mx-auto mb-3">
                        <img src="{{ asset('favicon/share.png') }}" alt="step3" class="w-5 h-5 object-contain" loading="lazy" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-1">Get Your Results</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">View your score and download the PDF result</p>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     TUTORIAL SECTION (BARU)
═════════════════════════════════════════════════════ --}}
<section class="bg-slate-50 py-20 px-4 lg:px-8" id="tutorial">
    <div class="max-w-screen-xl mx-auto">

        <div class="mb-10">
            <span class="text-xs font-semibold text-blue-950 uppercase tracking-widest">Tutorial</span>
            <h2 class="text-3xl font-bold text-slate-900 mt-2 mb-3">How to Use the Platform</h2>
            <p class="text-slate-500 text-base leading-relaxed max-w-xl">
                Watch these short video guides to get started with the TOEIC simulation platform.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Video 1 --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 hover:shadow-md transition-shadow">
                <div class="aspect-video w-full">
                    <iframe
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                        title="Getting Started with TOEIC PNB"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
                <div class="p-4">
                    <span class="text-xs font-semibold text-blue-950 uppercase tracking-wide">Part 1</span>
                    <h4 class="font-semibold text-slate-800 text-sm mt-1 mb-1">Getting Started</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">How to register, log in, and navigate the platform</p>
                </div>
            </div>

            {{-- Video 2 --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 hover:shadow-md transition-shadow">
                <div class="aspect-video w-full">
                    <iframe
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/9bZkp7q19f0"
                        title="Taking the Listening Test"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
                <div class="p-4">
                    <span class="text-xs font-semibold text-blue-950 uppercase tracking-wide">Part 2</span>
                    <h4 class="font-semibold text-slate-800 text-sm mt-1 mb-1">Taking the Listening Test</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Step-by-step guide for completing the listening section</p>
                </div>
            </div>

            {{-- Video 3 --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 hover:shadow-md transition-shadow">
                <div class="aspect-video w-full">
                    <iframe
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/L_jWHffIx5E"
                        title="Reading Test & Getting Results"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
                <div class="p-4">
                    <span class="text-xs font-semibold text-blue-950 uppercase tracking-wide">Part 3</span>
                    <h4 class="font-semibold text-slate-800 text-sm mt-1 mb-1">Reading Test & Getting Results</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Complete the reading test and download your score PDF</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     FAQ SECTION
═════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 px-4 lg:px-8">
    <div class="max-w-screen-xl mx-auto">

        <div class="mb-10">
            <span class="text-base font-semibold text-blue-950 uppercase tracking-widest">FAQ</span>
            <h2 class="text-3xl font-semibold text-slate-900 mt-2">Frequently Asked Questions</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-4" id="accordion-faq" data-accordion="collapse">

            {{-- FAQ 1 --}}
            <div class="border border-gray-300 rounded-2xl overflow-hidden">
                <h2 id="faq-h-1">
                    <button
                        class="flex items-center justify-between w-full px-6 py-5 text-left text-base font-semibold text-slate-800 hover:bg-slate-50 transition-colors"
                        data-accordion-target="#faq-b-1"
                        aria-expanded="false"
                        aria-controls="faq-b-1">
                        <span>Why TOEIC?</span>
                        <i class="fa-solid fa-chevron-down text-sm text-slate-400 transition-transform"></i>
                    </button>
                </h2>
                <div id="faq-b-1" class="hidden" aria-labelledby="faq-h-1">
                    <div class="px-6 pb-6 text-base font-normal text-slate-500 leading-relaxed">
                        TOEIC is globally recognized and measures real-world English proficiency in workplace settings.
                        It is used by employers to evaluate candidates' communication skills.
                    </div>
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="border border-gray-300 rounded-2xl overflow-hidden">
                <h2 id="faq-h-2">
                    <button
                        class="flex items-center justify-between w-full px-6 py-5 text-left text-base font-semibold text-slate-800 hover:bg-slate-50 transition-colors"
                        data-accordion-target="#faq-b-2"
                        aria-expanded="false"
                        aria-controls="faq-b-2">
                        <span>Can I take the test at home?</span>
                        <i class="fa-solid fa-chevron-down text-sm text-slate-400 transition-transform"></i>
                    </button>
                </h2>
                <div id="faq-b-2" class="hidden" aria-labelledby="faq-h-2">
                    <div class="px-6 pb-6 text-base font-normal text-slate-500 leading-relaxed">
                        This simulation is available online and can be accessed anytime.
                        The official TOEIC exam requires scheduling at an authorized test center.
                    </div>
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="border border-gray-300 rounded-2xl overflow-hidden">
                <h2 id="faq-h-3">
                    <button
                        class="flex items-center justify-between w-full px-6 py-5 text-left text-base font-semibold text-slate-800 hover:bg-slate-50 transition-colors"
                        data-accordion-target="#faq-b-3"
                        aria-expanded="false"
                        aria-controls="faq-b-3">
                        <span>Will I receive a certificate?</span>
                        <i class="fa-solid fa-chevron-down text-sm text-slate-400 transition-transform"></i>
                    </button>
                </h2>
                <div id="faq-b-3" class="hidden" aria-labelledby="faq-h-3">
                    <div class="px-6 pb-6 text-base font-normal text-slate-500 leading-relaxed">
                        After completing the simulation, you can download a PDF score report from your profile page.
                    </div>
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="border border-gray-300 rounded-2xl overflow-hidden">
                <h2 id="faq-h-4">
                    <button
                        class="flex items-center justify-between w-full px-6 py-5 text-left text-base font-semibold text-slate-800 hover:bg-slate-50 transition-colors"
                        data-accordion-target="#faq-b-4"
                        aria-expanded="false"
                        aria-controls="faq-b-4">
                        <span>Will my test result data be saved?</span>
                        <i class="fa-solid fa-chevron-down text-sm text-slate-400 transition-transform"></i>
                    </button>
                </h2>
                <div id="faq-b-4" class="hidden" aria-labelledby="faq-h-4">
                    <div class="px-6 pb-6 text-base font-normal text-slate-500 leading-relaxed">
                        Yes, your score and result history are saved in the system and accessible via your profile page anytime.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
