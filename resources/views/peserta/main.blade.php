<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>@yield('Title')</title>

    <!-- Anti-Back dari Halaman Soal -->
    <script>
        (function () {
            const cameFromExam = sessionStorage.getItem('came_from_exam');

            if (cameFromExam === '1') {
                const cameFromExamTime = parseInt(sessionStorage.getItem('came_from_exam_time') || '0');
                const isRecent = Date.now() - cameFromExamTime < 30 * 60 * 1000;

                if (isRecent) {
                    history.pushState(null, '', location.href);
                    history.pushState(null, '', location.href);
                } else {
                    sessionStorage.removeItem('came_from_exam');
                    sessionStorage.removeItem('came_from_exam_time');
                }
            }
        })();
    </script>
</head>

<body style="font-family: 'Poppins'">

    <!-- Modal: Tampil saat user back dari halaman soal ke dashboard -->
    <div id="alreadyLeftModal" class="fixed inset-0 z-[99999] hidden items-center justify-center" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-100 px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-circle-xmark text-slate-500 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Exam Session Ended</h3>
                    <p class="text-xs text-slate-500 mt-0.5">You cannot return to the exam</p>
                </div>
            </div>
            <div class="px-6 py-5">
                <p class="text-slate-600 text-sm leading-relaxed">
                    You have already left the exam session.
                    <strong class="text-slate-800">The exam can only be taken once</strong>
                    and cannot be continued after leaving.
                </p>
                <div class="mt-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                    <p class="text-slate-500 text-xs font-medium flex items-start gap-2">
                        <i class="fa-solid fa-circle-info mt-0.5 shrink-0"></i>
                        Please contact your exam supervisor if you have any questions.
                    </p>
                </div>
            </div>
            <div class="px-6 pb-5">
                <button id="alreadyLeftModalOk" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold transition-colors">OK, Back to Dashboard</button>
            </div>
        </div>
    </div>

    {{-- Animation Loading container removed to speed up perceptual navigation --}}
    @include('layouts.dashboard.navbar')
    @include('layouts.dashboard.sidebar')
    @yield('content')
    @include('layouts.dashboard.scripts')

    @include('sweetalert::alert')

    <!-- Anti-Back dari Halaman Soal + Modal "Already Left" -->
    <script>
        (function () {
            'use strict';

            const flag = sessionStorage.getItem('came_from_exam');
            const flagAt = parseInt(sessionStorage.getItem('came_from_exam_time') || '0');
            const TTL = 30 * 60 * 1000;
            const isValid = flag === '1' && Date.now() - flagAt < TTL;

            if (!isValid) return;

            const EXAM_PATHS = [
                '/SoalReading',
                '/SoalListening',
                '/Reading',
                '/Listening',
            ];

            const isExamPath = (pathname) =>
                EXAM_PATHS.some((p) => pathname.startsWith(p));

            const modal = document.getElementById('alreadyLeftModal');
            const modalOk = document.getElementById('alreadyLeftModalOk');

            const showModal = () => modal?.classList.replace('hidden', 'flex');
            const hideModal = () => modal?.classList.replace('flex', 'hidden');
            const lockHistory = () => {
                history.pushState(null, '', location.href);
                history.pushState(null, '', location.href);
            };

            document.addEventListener('DOMContentLoaded', lockHistory);

            window.addEventListener('popstate', () => {
                if (isExamPath(location.pathname)) {
                    lockHistory();
                    showModal();
                }
            });

            document.addEventListener('keydown', (e) => {
                if ((e.altKey && e.key === 'ArrowLeft') || e.key === 'BrowserBack') {
                    e.preventDefault();
                    e.stopPropagation();
                    showModal();
                }
            });

            modalOk?.addEventListener('click', () => {
                hideModal();
                if (isExamPath(location.pathname)) {
                    window.location.replace('/peserta');
                } else {
                    lockHistory();
                }
            });

            const remaining = TTL - (Date.now() - flagAt);
            setTimeout(() => {
                sessionStorage.removeItem('came_from_exam');
                sessionStorage.removeItem('came_from_exam_time');
            }, remaining);
        })();
    </script>

</body>
</html>