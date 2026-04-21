@extends('landing.main')

@section('Title', 'TOEIC Assessment — Politeknik Negeri Bali')

@section('content')

{{-- ══════════════════════════════════════════════════════
     PAGE ANIMATIONS & GLASS STYLES
═════════════════════════════════════════════════════ --}}
<style>
    /* --- Fade-up entrance animation --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(32px); }
        to   { opacity: 1; transform: translateY(0);    }
    }
    .anim-1 { animation: fadeInUp .65s ease-out .10s both; }
    .anim-2 { animation: fadeInUp .65s ease-out .25s both; }
    .anim-3 { animation: fadeInUp .65s ease-out .40s both; }
    .anim-4 { animation: fadeInUp .65s ease-out .55s both; }

    /* --- Glassmorphism card (dark bg) --- */
    .glass-dark {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.08);
    }

    /* --- Glassmorphism card (light bg) --- */
    .glass-light {
        background: rgba(255,255,255,0.75);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(219,234,254,0.6);
    }

    /* --- FAQ Modal --- */
    .faq-modal           { display: none; }
    .faq-modal.is-open   { display: flex; }

    /* --- Scroll-reveal (triggered by JS below) --- */
    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity .6s ease-out, transform .6s ease-out;
    }
    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal-delay-1 { transition-delay: .10s; }
    .reveal-delay-2 { transition-delay: .22s; }
    .reveal-delay-3 { transition-delay: .34s; }
    .reveal-delay-4 { transition-delay: .46s; }
</style>

{{-- ══════════════════════════════════════════════════════
     HERO SECTION
═════════════════════════════════════════════════════ --}}
<section class="relative bg-brand overflow-hidden pt-28 pb-20 px-4 sm:px-6 min-h-screen flex items-center" id="home">

    {{-- Soft radial glow di belakang --}}
    <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 65% 55% at 65% 45%, rgba(59,130,246,0.10) 0%, transparent 70%);"></div>

    <div class="relative max-w-5xl mx-auto w-full">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-center">

            {{-- Teks --}}
            <div class="text-center lg:text-left">
                <span class="anim-1 inline-flex items-center gap-1.5 glass-dark text-blue-200 text-xs font-semibold px-4 py-2 rounded-full mb-6 tracking-widest uppercase">
                    Politeknik Negeri Bali
                </span>
                <h1 class="anim-2 text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-5">
                    Try the <span class="text-brand-muted">TOEIC</span><br>Test Simulation
                </h1>
                <p class="anim-3 text-blue-300/80 text-sm sm:text-base leading-relaxed mb-8 max-w-md mx-auto lg:mx-0">
                    Improve your English proficiency score easily and effectively. Practice with real exam-style questions anytime, anywhere.
                </p>
                <div class="anim-4 flex flex-wrap gap-3 justify-center lg:justify-start">
                    <a href="{{ url('/DashboardSoal') }}"
                        class="inline-flex items-center gap-2 bg-brand-accent hover:bg-brand-accent-hover text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 no-underline shadow-lg shadow-blue-900/40">
                        Start Now
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#about"
                        class="inline-flex items-center gap-2 glass-dark hover:border-blue-300/30 text-blue-200 hover:text-white font-medium px-6 py-3 rounded-xl transition-all duration-200 no-underline">
                        Learn More
                    </a>
                </div>
            </div>

            {{-- Gambar — tampil di tablet (md+) --}}
            <div class="hidden md:flex justify-center">
                <img src="{{ asset('img/hero.png') }}" alt="TOEIC Simulation"
                    class="w-full max-w-xs sm:max-w-sm lg:max-w-md object-contain drop-shadow-2xl anim-2" loading="lazy" />
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     ABOUT SECTION
═════════════════════════════════════════════════════ --}}
<section class="bg-white py-16 sm:py-20 px-4 sm:px-6" id="about">
    <div class="max-w-5xl mx-auto">

        <div class="mb-10 reveal">
            <span class="text-xs font-semibold text-brand-accent uppercase tracking-widest">About</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2 mb-4">What is TOEIC?</h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-2xl">
                TOEIC (Test of English for International Communication) is a standardized test that measures English language proficiency in a workplace context, recognized globally by thousands of organizations.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-14">
            <div class="glass-light rounded-2xl p-4 sm:p-6 text-center reveal reveal-delay-1">
                <div class="text-2xl sm:text-3xl font-bold text-brand">200</div>
                <div class="text-xs sm:text-sm text-slate-500 mt-1">Questions per test</div>
            </div>
            <div class="glass-light rounded-2xl p-4 sm:p-6 text-center reveal reveal-delay-2">
                <div class="text-2xl sm:text-3xl font-bold text-brand">990</div>
                <div class="text-xs sm:text-sm text-slate-500 mt-1">Maximum score</div>
            </div>
            <div class="glass-light rounded-2xl p-4 sm:p-6 text-center reveal reveal-delay-3">
                <div class="text-2xl sm:text-3xl font-bold text-brand">120</div>
                <div class="text-xs sm:text-sm text-slate-500 mt-1">Minutes duration</div>
            </div>
        </div>

        {{-- Why TOEIC --}}
        <div class="reveal">
            <span class="text-xs font-semibold text-brand-accent uppercase tracking-widest">Why is TOEIC Important?</span>
            <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mt-2 mb-8">Benefits of Taking TOEIC</h3>
        </div>

        {{-- Benefits Grid — 2 col mobile, 4 col desktop --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div class="glass-light rounded-2xl p-4 sm:p-6 text-center hover:shadow-lg hover:shadow-blue-100/70 hover:-translate-y-1 transition-all duration-200 reveal reveal-delay-1">
                <img src="{{ asset('img/benefit 1.png') }}" alt="Industry Standard"
                    class="w-14 h-14 sm:w-20 sm:h-20 object-contain mx-auto mb-3 sm:mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-xs sm:text-sm mb-1">Industry Requirements Standard</h4>
                <p class="text-xs text-slate-500 leading-relaxed hidden sm:block">Recognized by 14,000+ companies worldwide</p>
            </div>
            <div class="glass-light rounded-2xl p-4 sm:p-6 text-center hover:shadow-lg hover:shadow-blue-100/70 hover:-translate-y-1 transition-all duration-200 reveal reveal-delay-2">
                <img src="{{ asset('img/benefit 2.png') }}" alt="Self-Confidence"
                    class="w-14 h-14 sm:w-20 sm:h-20 object-contain mx-auto mb-3 sm:mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-xs sm:text-sm mb-1">Self-Confidence Booster</h4>
                <p class="text-xs text-slate-500 leading-relaxed hidden sm:block">Build confidence in English communication</p>
            </div>
            <div class="glass-light rounded-2xl p-4 sm:p-6 text-center hover:shadow-lg hover:shadow-blue-100/70 hover:-translate-y-1 transition-all duration-200 reveal reveal-delay-3">
                <img src="{{ asset('img/benefit 3.png') }}" alt="English Skills"
                    class="w-14 h-14 sm:w-20 sm:h-20 object-contain mx-auto mb-3 sm:mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-xs sm:text-sm mb-1">Improve Your English Skills</h4>
                <p class="text-xs text-slate-500 leading-relaxed hidden sm:block">Sharpen listening and reading abilities</p>
            </div>
            <div class="glass-light rounded-2xl p-4 sm:p-6 text-center hover:shadow-lg hover:shadow-blue-100/70 hover:-translate-y-1 transition-all duration-200 reveal reveal-delay-4">
                <img src="{{ asset('img/benefit 4.png') }}" alt="Communication"
                    class="w-14 h-14 sm:w-20 sm:h-20 object-contain mx-auto mb-3 sm:mb-4" loading="lazy" />
                <h4 class="font-semibold text-slate-800 text-xs sm:text-sm mb-1">Improve Communication Skill</h4>
                <p class="text-xs text-slate-500 leading-relaxed hidden sm:block">Develop professional English communication</p>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     TEST COVERAGE SECTION
═════════════════════════════════════════════════════ --}}
<section class="relative bg-brand overflow-hidden py-16 sm:py-20 px-4 sm:px-6">

    <div class="relative max-w-5xl mx-auto">

        <div class="mb-8 sm:mb-10 reveal">
            <span class="text-xs font-semibold text-blue-300/80 uppercase tracking-widest">Test Coverage</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-white mt-2">TOEIC Simulation Test Coverage</h2>
        </div>

        {{-- Coverage Cards --}}
        <div class="grid sm:grid-cols-2 gap-4 sm:gap-5 mb-6 sm:mb-8">

            {{-- Listening --}}
            <div class="glass-dark rounded-2xl p-5 sm:p-6 reveal reveal-delay-1">
                <h3 class="text-sm sm:text-base font-semibold text-white mb-4 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-blue-400/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-headphones text-blue-200 text-sm"></i>
                    </span>
                    Listening Section
                </h3>
                <ul class="space-y-2.5">
                    <li class="flex items-center gap-2.5 text-blue-100/80 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/70 flex-shrink-0"></span>
                        100 questions
                    </li>
                    <li class="flex items-center gap-2.5 text-blue-100/80 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/70 flex-shrink-0"></span>
                        45 minutes
                    </li>
                    <li class="flex items-center gap-2.5 text-blue-100/80 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/70 flex-shrink-0"></span>
                        Part 1–4: Photographs, Q&R, Conversations, Talks
                    </li>
                </ul>
            </div>

            {{-- Reading --}}
            <div class="glass-dark rounded-2xl p-5 sm:p-6 reveal reveal-delay-2">
                <h3 class="text-sm sm:text-base font-semibold text-white mb-4 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-blue-400/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-book-open text-blue-200 text-sm"></i>
                    </span>
                    Reading Section
                </h3>
                <ul class="space-y-2.5">
                    <li class="flex items-center gap-2.5 text-blue-100/80 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/70 flex-shrink-0"></span>
                        100 questions
                    </li>
                    <li class="flex items-center gap-2.5 text-blue-100/80 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/70 flex-shrink-0"></span>
                        75 minutes
                    </li>
                    <li class="flex items-center gap-2.5 text-blue-100/80 text-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/70 flex-shrink-0"></span>
                        Part 5–7: Incomplete Sentences, Text Completion, Passages
                    </li>
                </ul>
            </div>

        </div>

        {{-- Steps --}}
        <div class="glass-dark rounded-2xl overflow-hidden reveal">
            <div class="grid sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-white/5">

                <div class="p-6 sm:p-7 text-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-400/15 border border-blue-300/10 flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('favicon/form.png') }}" alt="step1"
                            class="w-6 h-6 object-contain"
                            style="filter: brightness(0) invert(1) opacity(0.85);" loading="lazy" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-2">Follow Test Rules</h4>
                    <p class="text-xs text-blue-200/60 leading-relaxed">Understand and follow all exam regulations before starting</p>
                </div>

                <div class="p-6 sm:p-7 text-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-400/15 border border-blue-300/10 flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('favicon/create.png') }}" alt="step2"
                            class="w-6 h-6 object-contain"
                            style="filter: brightness(0) invert(1) opacity(0.85);" loading="lazy" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-2">Work the Test</h4>
                    <p class="text-xs text-blue-200/60 leading-relaxed">Complete the Listening and Reading sections</p>
                </div>

                <div class="p-6 sm:p-7 text-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-400/15 border border-blue-300/10 flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('favicon/share.png') }}" alt="step3"
                            class="w-6 h-6 object-contain"
                            style="filter: brightness(0) invert(1) opacity(0.85);" loading="lazy" />
                    </div>
                    <h4 class="font-semibold text-white text-sm mb-2">Get Your Results</h4>
                    <p class="text-xs text-blue-200/60 leading-relaxed">View your score and download the PDF result</p>
                </div>

            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     TUTORIAL SECTION — dicomment sampai video tersedia
     Uncomment bagian ini setelah video asli disiapkan
═════════════════════════════════════════════════════ --}}
{{--
<section class="bg-brand-light py-16 sm:py-20 px-4 sm:px-6" id="tutorial">
    <div class="max-w-5xl mx-auto">

        <div class="mb-10 reveal">
            <span class="text-xs font-semibold text-brand-accent uppercase tracking-widest">Tutorial</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2 mb-3">How to Use the Platform</h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-xl">
                Watch these short video guides to get started with the TOEIC simulation platform.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">

            <div class="glass-light rounded-2xl overflow-hidden hover:shadow-md hover:shadow-blue-100 transition-shadow reveal reveal-delay-1">
                <div class="aspect-video w-full">
                    <iframe class="w-full h-full"
                        src="GANTI_URL_VIDEO_1"
                        title="Getting Started with TOEIC PNB"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen loading="lazy">
                    </iframe>
                </div>
                <div class="p-4">
                    <span class="text-xs font-semibold text-brand-accent uppercase tracking-wide">Part 1</span>
                    <h4 class="font-semibold text-slate-800 text-sm mt-1 mb-1">Getting Started</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">How to register, log in, and navigate the platform</p>
                </div>
            </div>

            <div class="glass-light rounded-2xl overflow-hidden hover:shadow-md hover:shadow-blue-100 transition-shadow reveal reveal-delay-2">
                <div class="aspect-video w-full">
                    <iframe class="w-full h-full"
                        src="GANTI_URL_VIDEO_2"
                        title="Taking the Listening Test"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen loading="lazy">
                    </iframe>
                </div>
                <div class="p-4">
                    <span class="text-xs font-semibold text-brand-accent uppercase tracking-wide">Part 2</span>
                    <h4 class="font-semibold text-slate-800 text-sm mt-1 mb-1">Taking the Listening Test</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Step-by-step guide for completing the listening section</p>
                </div>
            </div>

            <div class="glass-light rounded-2xl overflow-hidden hover:shadow-md hover:shadow-blue-100 transition-shadow reveal reveal-delay-3">
                <div class="aspect-video w-full">
                    <iframe class="w-full h-full"
                        src="GANTI_URL_VIDEO_3"
                        title="Reading Test & Getting Results"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen loading="lazy">
                    </iframe>
                </div>
                <div class="p-4">
                    <span class="text-xs font-semibold text-brand-accent uppercase tracking-wide">Part 3</span>
                    <h4 class="font-semibold text-slate-800 text-sm mt-1 mb-1">Reading Test & Getting Results</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Complete the reading test and download your score PDF</p>
                </div>
            </div>

        </div>
    </div>
</section>
--}}

{{-- ══════════════════════════════════════════════════════
     FAQ SECTION — 2-column independent column accordion
═════════════════════════════════════════════════════ --}}
<section class="bg-white py-16 sm:py-20 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">

        <div class="mb-10 reveal">
            <span class="text-xs font-semibold text-brand-accent uppercase tracking-widest">FAQ</span>
            <h2 class="text-2xl sm:text-3xl font-semibold text-slate-900 mt-2">Frequently Asked Questions</h2>
        </div>

        {{--
            Dua kolom TERPISAH (bukan grid biasa):
            Kolom kiri: FAQ 1, 3 | Kolom kanan: FAQ 2, 4
            Expand kiri → hanya geser FAQ 3 di bawahnya, tidak menyentuh kolom kanan sama sekali.
        --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-4 items-start">

            {{-- ── Kolom Kiri ── --}}
            <div class="space-y-3">

                {{-- FAQ 1 --}}
                <div class="glass-light rounded-2xl overflow-hidden reveal reveal-delay-1">
                    <button class="faq-btn w-full flex items-center justify-between px-5 sm:px-6 py-5 text-left hover:bg-blue-50/50 transition-colors duration-200" aria-expanded="false">
                        <span class="text-sm font-semibold text-slate-800 pr-4">Why TOEIC?</span>
                        <i class="fa-solid fa-chevron-down text-xs text-blue-400 flex-shrink-0 faq-icon" style="transition: transform .3s ease;"></i>
                    </button>
                    <div class="faq-body overflow-hidden" style="max-height:0; transition: max-height .38s cubic-bezier(0.4,0,0.2,1);">
                        <div class="px-5 sm:px-6 pb-5 pt-1 text-sm text-slate-500 leading-relaxed border-t border-blue-50">
                            TOEIC is globally recognized and measures real-world English proficiency in workplace settings.
                            It is used by employers to evaluate candidates' communication skills.
                        </div>
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="glass-light rounded-2xl overflow-hidden reveal reveal-delay-3">
                    <button class="faq-btn w-full flex items-center justify-between px-5 sm:px-6 py-5 text-left hover:bg-blue-50/50 transition-colors duration-200" aria-expanded="false">
                        <span class="text-sm font-semibold text-slate-800 pr-4">Will I receive a certificate?</span>
                        <i class="fa-solid fa-chevron-down text-xs text-blue-400 flex-shrink-0 faq-icon" style="transition: transform .3s ease;"></i>
                    </button>
                    <div class="faq-body overflow-hidden" style="max-height:0; transition: max-height .38s cubic-bezier(0.4,0,0.2,1);">
                        <div class="px-5 sm:px-6 pb-5 pt-1 text-sm text-slate-500 leading-relaxed border-t border-blue-50">
                            After completing the simulation, you can download a PDF score report directly from your profile page.
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Kolom Kanan ── --}}
            <div class="space-y-3">

                {{-- FAQ 2 --}}
                <div class="glass-light rounded-2xl overflow-hidden reveal reveal-delay-2">
                    <button class="faq-btn w-full flex items-center justify-between px-5 sm:px-6 py-5 text-left hover:bg-blue-50/50 transition-colors duration-200" aria-expanded="false">
                        <span class="text-sm font-semibold text-slate-800 pr-4">Can I take the test at home?</span>
                        <i class="fa-solid fa-chevron-down text-xs text-blue-400 flex-shrink-0 faq-icon" style="transition: transform .3s ease;"></i>
                    </button>
                    <div class="faq-body overflow-hidden" style="max-height:0; transition: max-height .38s cubic-bezier(0.4,0,0.2,1);">
                        <div class="px-5 sm:px-6 pb-5 pt-1 text-sm text-slate-500 leading-relaxed border-t border-blue-50">
                            This simulation is available online and can be accessed anytime, anywhere.
                            The official TOEIC exam requires scheduling at an authorized test center.
                        </div>
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="glass-light rounded-2xl overflow-hidden reveal reveal-delay-4">
                    <button class="faq-btn w-full flex items-center justify-between px-5 sm:px-6 py-5 text-left hover:bg-blue-50/50 transition-colors duration-200" aria-expanded="false">
                        <span class="text-sm font-semibold text-slate-800 pr-4">Will my test result data be saved?</span>
                        <i class="fa-solid fa-chevron-down text-xs text-blue-400 flex-shrink-0 faq-icon" style="transition: transform .3s ease;"></i>
                    </button>
                    <div class="faq-body overflow-hidden" style="max-height:0; transition: max-height .38s cubic-bezier(0.4,0,0.2,1);">
                        <div class="px-5 sm:px-6 pb-5 pt-1 text-sm text-slate-500 leading-relaxed border-t border-blue-50">
                            Yes — your score and full result history are securely stored and accessible via your profile page at any time.
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     SCRIPTS: Scroll Reveal + FAQ Accordion
═════════════════════════════════════════════════════ --}}
<script>
(function () {
    /* ── Scroll-reveal ── */
    const revealObs = new IntersectionObserver(
        (entries) => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }),
        { threshold: 0.12 }
    );
    document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

    /* ── FAQ Accordion ── */
    const btns = document.querySelectorAll('.faq-btn');

    function closeAll(except) {
        btns.forEach(b => {
            if (b === except) return;
            b.setAttribute('aria-expanded', 'false');
            b.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
            b.nextElementSibling.style.maxHeight = '0';
        });
    }

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            const body   = btn.nextElementSibling;
            const icon   = btn.querySelector('.faq-icon');
            const isOpen = btn.getAttribute('aria-expanded') === 'true';

            closeAll(btn);

            if (isOpen) {
                btn.setAttribute('aria-expanded', 'false');
                icon.style.transform = 'rotate(0deg)';
                body.style.maxHeight = '0';
            } else {
                btn.setAttribute('aria-expanded', 'true');
                icon.style.transform = 'rotate(180deg)';
                body.style.maxHeight = body.scrollHeight + 'px';
            }
        });
    });
})();
</script>

@endsection
