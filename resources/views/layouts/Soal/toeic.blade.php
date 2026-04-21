<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        window.history.forward(1);
    </script>
</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col font-['Poppins'] relative text-slate-800">
    
    {{-- Animation Loading (Glass Blur - Sync with Dashboard) --}}
    <div id="overlay" class="fixed inset-0 z-[999]"
         style="display:none;background:rgba(15,23,42,0.30);backdrop-filter:blur(3px);align-items:center;justify-content:center;">
        <svg class="animate-spin" width="45" height="45" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" opacity=".25"/>
            <path d="M4 12a8 8 0 018-8" stroke="white" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    {{-- Top Navigation Bar --}}
    <header class="bg-white border-b border-gray-200 px-4 md:px-6 py-2.5 sticky top-0 z-50 shadow-sm">
        <nav class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('img/logo unit.png')}}" alt="Logo PNB" class="h-8 md:h-9">
                <div class="hidden sm:flex flex-col leading-tight">
                    <span class="text-[13px] font-bold text-slate-800 tracking-wide">TOEIC Assessment</span>
                    <span class="text-[10px] text-slate-500">Politeknik Negeri Bali</span>
                </div>
            </div>
            
            <div class="flex items-center">
                @yield('timer')
            </div>
        </nav>
    </header>

    {{-- Main Content Area --}}
    <main class="flex-1 max-w-5xl mx-auto w-full p-4 md:p-6 relative">
        @yield('content')
    </main>

    {{-- Global Image Lightbox Modal --}}
    <div id="image-modal" class="fixed inset-0 z-[1000] hidden bg-slate-900/90 backdrop-blur-sm cursor-zoom-out items-center justify-center p-4">
        <img id="modal-img" src="" alt="Zoomed Image" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl transition-transform duration-300">
        <button id="close-modal" class="absolute top-4 right-4 md:top-6 md:right-6 text-white bg-slate-800/50 hover:bg-slate-700 rounded-full w-10 h-10 flex items-center justify-center transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    {{-- Mencegah navigasi back pada browser --}}
    <script>
        history.replaceState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.replaceState(null, null, document.URL);
        });
    </script>

    {{-- Script Interaktivitas (Loading & Lightbox) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Loading Overlay ---
            const forms = document.querySelectorAll('form');
            const overlay = document.getElementById('overlay');
    
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    overlay.style.display = 'flex';
                });
            });
    
            window.addEventListener('load', function() {
                overlay.style.display = 'none';
            });

            window.addEventListener('pageshow', (event) => {
                if (event.persisted) { overlay.style.display = 'none'; }
            });

            // --- Image Lightbox Modal ---
            const imageModal = document.getElementById('image-modal');
            const modalImg = document.getElementById('modal-img');
            const clickableImages = document.querySelectorAll('.zoomable-image');

            clickableImages.forEach(img => {
                img.addEventListener('click', function() {
                    modalImg.src = this.src;
                    imageModal.classList.remove('hidden');
                    imageModal.classList.add('flex');
                    document.body.style.overflow = 'hidden'; // prevent background scrolling
                });
            });

            // Close modal by clicking anywhere or pressing Esc
            const closeModal = () => {
                imageModal.classList.add('hidden');
                imageModal.classList.remove('flex');
                document.body.style.overflow = '';
            };

            imageModal.addEventListener('click', closeModal);
            
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !imageModal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>

</body>
</html>
