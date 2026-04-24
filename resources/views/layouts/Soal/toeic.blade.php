<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Anti-Back Browser: pushState ganda -->
    <script>
        (function () {
            history.pushState(null, '', location.href);
            history.pushState(null, '', location.href);
        })();
    </script>
</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col font-['Poppins'] relative text-slate-800">
    
    <!-- MODAL 1: Konfirmasi saat user menekan tombol Back browser/HP -->
    <div id="backConfirmModal" class="fixed inset-0 z-[99999] hidden items-center justify-center" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 overflow-hidden">
            <div class="bg-red-50 border-b border-red-100 px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Leave Exam?</h3>
                    <p class="text-xs text-slate-500 mt-0.5">This action cannot be undone</p>
                </div>
            </div>
            <div class="px-6 py-5">
                <p class="text-slate-600 text-sm leading-relaxed">
                    Are you sure you want to leave the exam? You will be redirected to the <strong class="text-slate-800">dashboard</strong> and <strong class="text-red-600">cannot return to continue this exam.</strong>
                </p>
                <div class="mt-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                    <p class="text-amber-700 text-xs font-medium flex items-start gap-2">
                        <i class="fa-solid fa-clock-rotate-left mt-0.5 shrink-0"></i>
                        Your answers so far will still be saved, but the exam session will end.
                    </p>
                </div>
            </div>
            <div class="px-6 pb-5 flex gap-3">
                <button id="backModalCancel" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">Stay in Exam</button>
                <button id="backModalConfirm" class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-colors">Leave Exam</button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: Konfirmasi saat user menekan Refresh (F5 / Ctrl+R) -->
    <div id="refreshConfirmModal" class="fixed inset-0 z-[99999] hidden items-center justify-center" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 overflow-hidden">
            <div class="bg-blue-50 border-b border-blue-100 px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-rotate-right text-blue-500 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Refresh Page?</h3>
                    <p class="text-xs text-slate-500 mt-0.5">The exam will continue after refresh</p>
                </div>
            </div>
            <div class="px-6 py-5">
                <p class="text-slate-600 text-sm leading-relaxed">
                    Are you sure you want to refresh this page? The exam timer will <strong class="text-slate-800">continue running</strong> and your <strong class="text-blue-600">answers on this part will not be saved</strong> until you click Next or Submit.
                </p>
                <div class="mt-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                    <p class="text-blue-700 text-xs font-medium flex items-start gap-2">
                        <i class="fa-solid fa-info-circle mt-0.5 shrink-0"></i>
                        Answers from previous parts that were already submitted are safe.
                    </p>
                </div>
            </div>
            <div class="px-6 pb-5 flex gap-3">
                <button id="refreshModalCancel" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">Cancel</button>
                <button id="refreshModalConfirm" class="flex-1 px-4 py-2.5 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold transition-colors">Refresh</button>
            </div>
        </div>
    </div>

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

<!-- Script: Anti-Back + Modal Konfirmasi Back + Modal Konfirmasi Refresh -->
<!-- Versi 3 — Fix: history.go() replaced, beforeunload dinamis -->
<script>
(function () {
    'use strict';

    const isExamPage = document.getElementById('toeic_form') !== null;
    const backModal = document.getElementById('backConfirmModal');
    const backModalCancel = document.getElementById('backModalCancel');
    const backModalConfirm = document.getElementById('backModalConfirm');
    const refreshModal = document.getElementById('refreshConfirmModal');
    const refreshModalCancel = document.getElementById('refreshModalCancel');
    const refreshModalConfirm = document.getElementById('refreshModalConfirm');

    let refreshConfirmed = false;
    let backConfirmed = false;
    let isSubmitting = false;

    function showModal(modal) {
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideModal(modal) {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // beforeunload handler - dinamis (daftar/hapus saat perlu)
    function beforeUnloadHandler(e) {
        if (isSubmitting || refreshConfirmed || backConfirmed) {
            window.removeEventListener('beforeunload', beforeUnloadHandler);
            return;
        }
        e.preventDefault();
        e.returnValue = '';
    }

    function activateBeforeUnload() {
        window.removeEventListener('beforeunload', beforeUnloadHandler);
        window.addEventListener('beforeunload', beforeUnloadHandler);
    }

    function deactivateBeforeUnload() {
        window.removeEventListener('beforeunload', beforeUnloadHandler);
    }

    // Deteksi submit form
    if (isExamPage) {
        document.addEventListener('submit', function () {
            isSubmitting = true;
            deactivateBeforeUnload();
        }, true);
    }

    // Push state ganda saat DOM siap
    document.addEventListener('DOMContentLoaded', function () {
        history.pushState(null, '', location.href);
        history.pushState(null, '', location.href);
    });

    // popstate handler
    window.addEventListener('popstate', function () {
        if (backConfirmed) return;

        if (isExamPage) {
            showModal(backModal);
        }

        history.pushState(null, '', location.href);
        history.pushState(null, '', location.href);
    });

    // Block keyboard shortcut back
    document.addEventListener('keydown', function (e) {
        if ((e.altKey && e.key === 'ArrowLeft') || e.key === 'BrowserBack') {
            e.preventDefault();
            e.stopPropagation();
            if (isExamPage && !backConfirmed) {
                showModal(backModal);
            }
        }
    });

    // Tombol Stay in Exam
    if (backModalCancel) {
        backModalCancel.addEventListener('click', function () {
            hideModal(backModal);
            history.pushState(null, '', location.href);
            history.pushState(null, '', location.href);
        });
    }

    // Tombol Leave Exam - hit /exam/leave dulu sebelum redirect
    if (backModalConfirm) {
        backModalConfirm.addEventListener('click', async function () {
            backConfirmed = true;
            deactivateBeforeUnload();

            this.textContent = 'Leaving...';
            this.disabled = true;

            sessionStorage.setItem('came_from_exam', '1');
            sessionStorage.setItem('came_from_exam_time', Date.now().toString());

            try {
                await fetch('/exam/leave', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
            } catch (e) {
                console.warn('[LeaveExam] Fetch gagal, tetap redirect:', e);
            }

            window.location.replace('/peserta');
        });
    }

    // Modal Refresh
    if (isExamPage) {
        document.addEventListener('keydown', function (e) {
            const isF5 = e.key === 'F5';
            const isCtrlR = (e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'r';
            const isCtrlShiftR = (e.ctrlKey || e.metaKey) && e.shiftKey && e.key.toLowerCase() === 'r';

            if (isF5 || isCtrlR || isCtrlShiftR) {
                if (refreshConfirmed) return;
                e.preventDefault();
                e.stopPropagation();

                activateBeforeUnload();

                showModal(refreshModal);
            }
        }, true);

        // Tombol Cancel - nonaktifkan beforeunload
        if (refreshModalCancel) {
            refreshModalCancel.addEventListener('click', function () {
                hideModal(refreshModal);
                deactivateBeforeUnload();
            });
        }

        // Tombol Refresh
        if (refreshModalConfirm) {
            refreshModalConfirm.addEventListener('click', function () {
                refreshConfirmed = true;
                deactivateBeforeUnload();

                this.textContent = 'Refreshing...';
                this.disabled = true;
                location.reload();
            });
        }
    }
})();
</script>

</body>
</html>
