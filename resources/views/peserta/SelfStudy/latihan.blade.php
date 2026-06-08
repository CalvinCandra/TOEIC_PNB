@extends('peserta.main')

@section('content')
    {{-- Immersive Exam Focus Mode Styles --}}
    <style>
        #drawer-navigation, nav.fixed {
            display: none !important;
        }
        main {
            margin-left: 0 !important;
            padding-top: 2rem !important;
        }
    </style>

    <main class="p-5 md:ml-64 md:px-8 lg:px-12 h-auto pt-20">
        <div class="my-6 max-w-4xl mx-auto">

            {{-- Header/Info Card --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-6 shadow-sm">
                <div class="flex items-center mb-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full border
                        {{ $part->kategori === 'Listening' 
                            ? 'bg-blue-50 text-blue-700 border-blue-100' 
                            : 'bg-emerald-50 text-emerald-700 border-emerald-100' }}">
                        <i class="fa-solid {{ $part->kategori === 'Listening' ? 'fa-headphones' : 'fa-book' }} text-[11px]"></i>
                        {{ $part->kategori }} — Self Study
                    </span>
                </div>
                
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight leading-snug">{{ $part->part }}</h1>
                <p class="text-[11px] text-slate-500 font-semibold mt-1.5">
                    <i class="fa-solid fa-folder-open text-slate-400 mr-0.5"></i> Question Bank: {{ $bank->bank }}
                </p>

                @if ($part->petunjuk)
                    <div class="mt-4 pt-4 border-t border-slate-100 text-xs sm:text-sm text-slate-650 leading-relaxed font-medium">
                        <h4 class="text-slate-800 font-bold mb-1 flex items-center gap-1.5"><i class="fa-solid fa-circle-info text-blue-500"></i> Directions:</h4>
                        {!! $part->petunjuk !!}
                    </div>
                @endif
            </div>

            {{-- Part-Level Audio (Listening) --}}
            @if ($part->kategori === 'Listening' && $part->audio)
                <div class="mb-6 bg-blue-50/50 border border-blue-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-blue-800 mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-headphones text-[13px]"></i> Part Audio Instructions (replay as needed)
                    </p>
                    <audio controls class="w-full">
                        <source src="{{ Storage::disk('s3')->url('audio/' . $part->audio->audio) }}" type="audio/mpeg">
                    </audio>
                </div>
            @endif

            {{-- Part-Level Multi-Question Passage Reference (Reading) --}}
            @if ($part->kategori === 'Reading' && $part->multi_soal)
                <div class="mb-6 bg-amber-50/50 border border-amber-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-amber-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> Multi-Question Passage Reference
                    </h3>
                    <div class="prose max-w-none text-slate-800 text-[14px] leading-relaxed">
                        {!! $part->multi_soal !!}
                    </div>
                </div>
            @endif

            <form action="/SelfStudy/Submit" method="POST" id="form-selfstudy" class="space-y-5">
                @csrf
                <input type="hidden" name="id_bank" value="{{ $bank->id_bank }}">
                <input type="hidden" name="id_part" value="{{ $part->id_part }}">
                <input type="hidden" name="durasi_detik" id="durasi_detik" value="0">

                @foreach ($soal as $s)
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="p-5 md:p-6">
                            
                            {{-- Question Header --}}
                            <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center shadow-inner font-extrabold text-[11px]">
                                    {{ $s->nomor_soal }}
                                </div>
                                Question
                            </h2>

                            {{-- Question/Passage Text --}}
                            @if ($s->text)
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 md:p-5 mb-4 text-slate-800 leading-relaxed text-[13px] prose max-w-none">
                                    {!! $s->text !!}
                                </div>
                            @endif

                            {{-- Question Specific Media --}}
                            <div class="flex flex-col gap-3.5 mb-4">
                                @if ($s->gambar)
                                    <div class="border border-slate-100 rounded-xl p-1.5 bg-slate-50 self-start max-w-full cursor-zoom-in group relative">
                                        <img src="{{ Storage::disk('s3')->url('gambar/' . $s->gambar->gambar) }}"
                                            class="zoomable-image max-h-64 object-contain rounded-lg w-full">
                                    </div>
                                @endif
                                
                                @if ($s->audio && $part->kategori === 'Listening')
                                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-2.5 w-full sm:w-max">
                                        <audio controls class="w-full h-8 sm:w-80">
                                            <source src="{{ Storage::disk('s3')->url('audio/' . $s->audio->audio) }}"
                                                type="audio/mpeg">
                                        </audio>
                                    </div>
                                @endif
                            </div>

                            {{-- Question Stem --}}
                            @if ($s->soal)
                                <div class="text-slate-800 font-bold text-[14px] leading-relaxed mb-4">
                                    {{ $s->soal }}
                                </div>
                            @endif

                            {{-- Premium Options List --}}
                            <div class="space-y-2.5">
                                @foreach (['A', 'B', 'C', 'D'] as $opt)
                                    @php $field = 'jawaban_' . strtolower($opt); @endphp
                                    @if ($s->$field)
                                        <label for="option{{ $opt }}_{{ $s->id_soal }}"
                                            class="flex items-center p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-blue-50/40 hover:border-blue-300 transition-colors group has-[:checked]:bg-blue-50 has-[:checked]:border-blue-550 has-[:checked]:ring-1 has-[:checked]:ring-blue-500 relative">
                                            <div class="flex items-center h-5 mr-3 shrink-0">
                                                <input type="radio" 
                                                    id="option{{ $opt }}_{{ $s->id_soal }}"
                                                    name="jawaban[{{ $s->id_soal }}]"
                                                    value="{{ $opt }}" 
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                            </div>
                                            <div class="text-slate-700 text-xs sm:text-sm group-hover:text-slate-900 group-has-[:checked]:font-semibold select-none leading-snug w-full">
                                                {{ $s->$field }}
                                            </div>
                                        </label>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endforeach

                {{-- Action Bar (Centered Floating Pill Layout) --}}
                <div class="sticky bottom-6 max-w-md mx-auto bg-white/90 backdrop-blur-md border border-slate-200/70 rounded-full px-5 py-3 shadow-xl shadow-slate-200/30 flex justify-between items-center z-30 mt-10 transition-all">
                    <a href="/SelfStudy/Bank/{{ $bank->id_bank }}" id="btn-cancel-practice"
                        class="px-4 py-2.5 rounded-full text-slate-500 hover:text-rose-600 hover:bg-rose-50/70 font-bold text-xs transition-all duration-200 active:scale-95 flex items-center gap-1.5 border border-transparent hover:border-rose-100">
                        <i class="fa-solid fa-xmark text-sm"></i> Cancel Practice
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full font-bold text-xs transition-all duration-200 shadow-md shadow-blue-150 hover:shadow-lg hover:shadow-blue-200/80 active:scale-95 flex items-center gap-1.5">
                        Submit Answers <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- Cancel Practice Confirmation Modal --}}
    <div id="cancel-modal" class="fixed inset-0 z-[1010] hidden bg-slate-900/60 backdrop-blur-sm items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white rounded-3xl p-6 shadow-2xl max-w-sm w-full border border-slate-100 transform scale-95 transition-all duration-300">
            <div class="w-12 h-12 bg-rose-50 rounded-full flex items-center justify-center text-rose-500 mx-auto mb-4 border border-rose-100/50">
                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-800 text-center mb-2">Exit Practice Session?</h3>
            <p class="text-xs text-slate-505 text-center leading-relaxed mb-6">
                Are you sure you want to cancel this practice session? Your progress and answers for this attempt will not be saved.
            </p>
            <div class="flex gap-3">
                <button type="button" id="btn-cancel-keep" class="flex-1 py-2.5 border border-slate-200 hover:bg-slate-50 rounded-full text-slate-650 font-bold text-xs transition-all active:scale-95">
                    Keep Practicing
                </button>
                <a href="/SelfStudy/Bank/{{ $bank->id_bank }}" class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-full font-bold text-xs text-center transition-all active:scale-95 flex items-center justify-center">
                    Yes, Cancel
                </a>
            </div>
        </div>
    </div>

    {{-- Submit Answers Confirmation Modal --}}
    <div id="submit-modal" class="fixed inset-0 z-[1010] hidden bg-slate-900/60 backdrop-blur-sm items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white rounded-3xl p-6 shadow-2xl max-w-sm w-full border border-slate-100 transform scale-95 transition-all duration-300">
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mx-auto mb-4 border border-blue-100/50">
                <i class="fa-solid fa-circle-check text-lg"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-800 text-center mb-2">Submit Your Answers?</h3>
            <p class="text-xs text-slate-505 text-center leading-relaxed mb-6">
                Please make sure you have answered all questions. Are you ready to grade this practice and see your scorecard?
            </p>
            <div class="flex gap-3">
                <button type="button" id="btn-submit-back" class="flex-1 py-2.5 border border-slate-200 hover:bg-slate-50 rounded-full text-slate-655 font-bold text-xs transition-all active:scale-95">
                    Go Back
                </button>
                <button type="button" id="btn-submit-confirm" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-bold text-xs transition-all active:scale-95">
                    Yes, Submit
                </button>
            </div>
        </div>
    </div>

    {{-- Global Image Lightbox Modal --}}
    <div id="image-modal" class="fixed inset-0 z-[1000] hidden bg-slate-900/90 backdrop-blur-sm cursor-zoom-out items-center justify-center p-4">
        <img id="modal-img" src="" alt="Zoomed Image" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl transition-transform duration-300">
        <button id="close-modal" class="absolute top-4 right-4 md:top-6 md:right-6 text-white bg-slate-800/50 hover:bg-slate-700 rounded-full w-10 h-10 flex items-center justify-center transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <script>
        const startTime = Date.now();
        let isConfirmed = false;
        
        const formSelfStudy = document.getElementById('form-selfstudy');
        const submitModal = document.getElementById('submit-modal');
        const btnSubmitBack = document.getElementById('btn-submit-back');
        const btnSubmitConfirm = document.getElementById('btn-submit-confirm');

        // Intercept form submit to show modern confirmation modal
        formSelfStudy.addEventListener('submit', (e) => {
            if (!isConfirmed) {
                e.preventDefault();
                submitModal.classList.remove('hidden');
                submitModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        });

        btnSubmitBack.addEventListener('click', () => {
            submitModal.classList.add('hidden');
            submitModal.classList.remove('flex');
            document.body.style.overflow = '';
        });

        btnSubmitConfirm.addEventListener('click', () => {
            isConfirmed = true;
            document.getElementById('durasi_detik').value = Math.floor((Date.now() - startTime) / 1000);
            formSelfStudy.submit();
        });

        // --- Cancel Practice Modal ---
        const btnCancelPractice = document.getElementById('btn-cancel-practice');
        const cancelModal = document.getElementById('cancel-modal');
        const btnCancelKeep = document.getElementById('btn-cancel-keep');

        btnCancelPractice.addEventListener('click', (e) => {
            e.preventDefault();
            cancelModal.classList.remove('hidden');
            cancelModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });

        btnCancelKeep.addEventListener('click', () => {
            cancelModal.classList.add('hidden');
            cancelModal.classList.remove('flex');
            document.body.style.overflow = '';
        });

        // --- Image Lightbox Modal ---
        const imageModal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-img');
        const clickableImages = document.querySelectorAll('.zoomable-image');

        clickableImages.forEach(img => {
            img.addEventListener('click', function(e) {
                e.stopPropagation();
                modalImg.src = this.src;
                imageModal.classList.remove('hidden');
                imageModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });
        });

        const closeModal = () => {
            imageModal.classList.add('hidden');
            imageModal.classList.remove('flex');
            document.body.style.overflow = '';
        };

        imageModal.addEventListener('click', closeModal);
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (!imageModal.classList.contains('hidden')) closeModal();
                if (!cancelModal.classList.contains('hidden')) {
                    cancelModal.classList.add('hidden');
                    cancelModal.classList.remove('flex');
                    document.body.style.overflow = '';
                }
                if (!submitModal.classList.contains('hidden')) {
                    submitModal.classList.add('hidden');
                    submitModal.classList.remove('flex');
                    document.body.style.overflow = '';
                }
            }
        });
    </script>
@endsection
