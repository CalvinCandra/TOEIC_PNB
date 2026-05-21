<nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed left-0 right-0 top-0 z-50 h-16 flex items-center">
    <div class="flex flex-wrap justify-between items-center w-full">

        {{-- Left: hamburger + brand --}}
        <div class="flex justify-start items-center">
            <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-3 text-gray-600 rounded-lg cursor-pointer md:hidden hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 transition-colors">
                <i class="fa-solid fa-bars text-lg"></i>
                <span class="sr-only">Toggle sidebar</span>
            </button>

            <a href="{{ url('/') }}" class="flex items-center gap-2.5 no-underline">
                <img src="{{ asset('img/logo unit.png') }}" class="h-8 sm:h-9 object-contain" alt="PNB Logos" />
                <div class="hidden sm:flex flex-col leading-tight">
                    <span class="text-sm font-bold text-slate-800 tracking-wide">TOEIC Assessment</span>
                    <span class="text-xs text-slate-500">Politeknik Negeri Bali</span>
                </div>
            </a>
        </div>

        {{-- Right: user menu --}}
        <div class="flex items-center lg:order-2">
            <button type="button"
                class="flex items-center gap-2.5 px-2 py-1.5 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors border border-transparent hover:border-gray-200"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Open user menu</span>
                <div class="w-8 h-8 rounded-full overflow-hidden bg-slate-100 shadow-sm border border-gray-200">
                    <img class="w-full h-full object-cover" src="{{ asset('profile/profile.png') }}" alt="user photo"
                        loading="lazy" />
                </div>
                <div class="hidden md:flex flex-col text-left mr-1">
                    <span class="text-xs font-bold text-slate-700 leading-tight">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-slate-500 capitalize leading-tight">{{ auth()->user()->level == 'peserta' ? 'Participant' : (auth()->user()->level == 'petugas' ? 'Staff' : 'Admin') }}</span>
                </div>
                <i id="navbar-user-chevron"
                    class="fa-solid fa-chevron-down text-xs text-gray-400 hidden md:block transition-transform duration-200"></i>
            </button>

            <!-- Dropdown menu -->
            <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded-xl divide-y divide-gray-100 shadow-xl border border-gray-100"
                id="dropdown">
                <div class="py-3 px-4 bg-slate-50 rounded-t-xl">
                    <span class="block text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</span>
                    <span class="block text-xs text-gray-500 truncate mt-0.5">{{ auth()->user()->email }}</span>
                </div>
                    <ul class="py-1 text-gray-700" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ url('/') }}"
                                class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <i class="fa-solid fa-house w-5 text-gray-400"></i> Landing Page
                            </a>
                        </li>
                        @if (auth()->user()->level == 'admin')
                            @php
                                $testingModeOn = \Illuminate\Support\Facades\Cache::get('testing_mode', false);
                                $toeicEnabled  = \App\Models\FeatureToggle::isEnabled('toeic_simulation');
                            @endphp

                            {{-- Hidden forms — submitted only after modal confirms --}}
                            <form id="form-testing-mode" action="/Admin/TestingMode" method="POST" class="hidden">
                                @csrf
                            </form>
                            <form id="form-toeic-toggle" action="/feature-toggle/toeic_simulation" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="is_enabled" value="{{ $toeicEnabled ? 0 : 1 }}">
                            </form>

                            <li class="border-t border-gray-50">
                                <button type="button"
                                    onclick="openToggleModal('testing-mode')"
                                    class="flex items-center justify-between w-full px-4 py-2 text-sm hover:bg-blue-50 transition-colors {{ $testingModeOn ? 'text-emerald-700' : 'text-gray-700' }}"
                                    title="Click to toggle Testing Mode">
                                    <div class="flex items-center font-medium">
                                        <i class="fa-solid fa-flask w-5 {{ $testingModeOn ? 'text-emerald-500' : 'text-gray-400' }}"></i>
                                        Testing Mode
                                    </div>
                                    <div class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors {{ $testingModeOn ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                        <span class="inline-block h-3 w-3 transform rounded-full bg-white shadow-sm transition-transform {{ $testingModeOn ? 'translate-x-4' : 'translate-x-1' }}"></span>
                                    </div>
                                </button>
                            </li>
                            <li class="border-t border-gray-50">
                                <button type="button"
                                    onclick="openToggleModal('toeic')"
                                    class="flex items-center justify-between w-full px-4 py-2 text-sm hover:bg-blue-50 transition-colors {{ $toeicEnabled ? 'text-emerald-700' : 'text-gray-700' }}"
                                    title="Click to toggle TOEIC Tryout">
                                    <div class="flex items-center font-medium">
                                        <i class="fa-solid fa-pencil w-5 {{ $toeicEnabled ? 'text-emerald-500' : 'text-gray-400' }}"></i>
                                        TOEIC Tryout
                                    </div>
                                    <div class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors {{ $toeicEnabled ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                        <span class="inline-block h-3 w-3 transform rounded-full bg-white shadow-sm transition-transform {{ $toeicEnabled ? 'translate-x-4' : 'translate-x-1' }}"></span>
                                    </div>
                                </button>
                            </li>
                        @endif
                        @if (auth()->user()->level == 'peserta')
                            <li>
                                <a href="{{ url('/reset-password') }}"
                                    class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-lock w-5 text-gray-400"></i> Change Password
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/download-result') }}" target="_blank"
                                    class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-download w-5 text-gray-400"></i> Download Result
                                </a>
                            </li>
                        @endif
                    </ul>
                <div class="py-1">
                    <button id="btn-signout-trigger" onclick="openSignOutModal()"
                        class="flex w-full items-center px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors text-left">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-red-500"></i> Sign Out
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- ══ Testing Mode Confirmation Modal ══ --}}
<div id="testing-mode-modal"
    class="fixed inset-0 z-[999] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-150 ease-out"
    aria-modal="true" role="dialog">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
    <div id="testing-mode-dialog"
        class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden w-full max-w-sm mx-4 transform scale-95 transition-transform duration-150 ease-out">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full mb-4
                {{ \Illuminate\Support\Facades\Cache::get('testing_mode', false) ? 'bg-red-50' : 'bg-emerald-50' }}">
                <i class="fa-solid fa-flask text-lg
                    {{ \Illuminate\Support\Facades\Cache::get('testing_mode', false) ? 'text-red-500' : 'text-emerald-500' }}"></i>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900">
                {{ \Illuminate\Support\Facades\Cache::get('testing_mode', false) ? 'Disable Testing Mode?' : 'Enable Testing Mode?' }}
            </h3>
            <p class="mb-6 text-sm text-gray-500">
                @if (\Illuminate\Support\Facades\Cache::get('testing_mode', false))
                    Testing Mode will be <strong>turned off</strong>. The system will return to normal production behaviour.
                @else
                    Testing Mode will be <strong>turned on</strong>. Use this only in a non-production environment.
                @endif
            </p>
            <div class="flex justify-center gap-3">
                <button onclick="closeToggleModal('testing-mode')" type="button"
                    class="w-full py-2.5 text-sm font-semibold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="document.getElementById('form-testing-mode').submit()"
                    class="w-full py-2.5 text-sm font-semibold rounded-xl transition-colors
                    {{ \Illuminate\Support\Facades\Cache::get('testing_mode', false) ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-emerald-600 hover:bg-emerald-700 text-white' }}">
                    {{ \Illuminate\Support\Facades\Cache::get('testing_mode', false) ? 'Yes, Disable' : 'Yes, Enable' }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ TOEIC Tryout Confirmation Modal ══ --}}
@php $toeicEnabledModal = \App\Models\FeatureToggle::isEnabled('toeic_simulation'); @endphp
<div id="toeic-modal"
    class="fixed inset-0 z-[999] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-150 ease-out"
    aria-modal="true" role="dialog">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
    <div id="toeic-dialog"
        class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden w-full max-w-sm mx-4 transform scale-95 transition-transform duration-150 ease-out">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full mb-4
                {{ $toeicEnabledModal ? 'bg-red-50' : 'bg-emerald-50' }}">
                <i class="fa-solid fa-pencil text-lg
                    {{ $toeicEnabledModal ? 'text-red-500' : 'text-emerald-500' }}"></i>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900">
                {{ $toeicEnabledModal ? 'Disable TOEIC Tryout?' : 'Enable TOEIC Tryout?' }}
            </h3>
            <p class="mb-6 text-sm text-gray-500">
                @if ($toeicEnabledModal)
                    The TOEIC Tryout card will be <strong>hidden</strong> from all participants immediately.
                @else
                    The TOEIC Tryout card will become <strong>visible</strong> to all participants immediately.
                @endif
            </p>
            <div class="flex justify-center gap-3">
                <button onclick="closeToggleModal('toeic')" type="button"
                    class="w-full py-2.5 text-sm font-semibold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="document.getElementById('form-toeic-toggle').submit()"
                    class="w-full py-2.5 text-sm font-semibold rounded-xl transition-colors
                    {{ $toeicEnabledModal ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-emerald-600 hover:bg-emerald-700 text-white' }}">
                    {{ $toeicEnabledModal ? 'Yes, Disable' : 'Yes, Enable' }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ Sign Out Confirmation Modal ══ --}}
<div id="signout-modal"
    class="fixed inset-0 z-[999] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-150 ease-out"
    aria-modal="true" role="dialog">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    {{-- Dialog Card --}}
    <div id="signout-dialog"
        class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden w-full max-w-sm mx-4 transform scale-95 transition-transform duration-150 ease-out">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mb-4">
                <i class="fa-solid fa-arrow-right-from-bracket text-red-500 text-lg"></i>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900">Sign Out?</h3>
            <p class="mb-6 text-sm text-gray-500">Are you sure you want to sign out? You will need to sign in again to
                access your account.</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeSignOutModal()" type="button"
                    class="w-full py-2.5 text-sm font-semibold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <a href="{{ url('/logout') }}"
                    class="w-full text-white bg-red-600 hover:bg-red-700 font-semibold rounded-xl text-sm inline-flex justify-center items-center py-2.5 transition-colors no-underline">
                    Yes, Sign Out
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const modal   = document.getElementById('signout-modal');
    const dialog  = document.getElementById('signout-dialog');
    const dropdown = document.getElementById('dropdown');

    /* ── Generic open/close helpers for feature-toggle modals ── */
    window.openToggleModal = (key) => {
        if (dropdown) dropdown.classList.add('hidden');
        const m = document.getElementById(key + '-modal');
        const d = document.getElementById(key + '-dialog');
        if (!m || !d) return;
        m.classList.remove('pointer-events-none');
        requestAnimationFrame(() => {
            m.classList.replace('opacity-0', 'opacity-100');
            d.classList.replace('scale-95', 'scale-100');
        });
    };

    window.closeToggleModal = (key) => {
        const m = document.getElementById(key + '-modal');
        const d = document.getElementById(key + '-dialog');
        if (!m || !d) return;
        m.classList.replace('opacity-100', 'opacity-0');
        d.classList.replace('scale-100', 'scale-95');
        setTimeout(() => m.classList.add('pointer-events-none'), 150);
    };

    /* ── Sign-out modal ── */
    window.openSignOutModal = () => {
        if (dropdown) dropdown.classList.add('hidden');
        modal.classList.remove('pointer-events-none');
        requestAnimationFrame(() => {
            modal.classList.replace('opacity-0', 'opacity-100');
            dialog.classList.replace('scale-95', 'scale-100');
        });
    };

    window.closeSignOutModal = () => {
        modal.classList.replace('opacity-100', 'opacity-0');
        dialog.classList.replace('scale-100', 'scale-95');
        setTimeout(() => modal.classList.add('pointer-events-none'), 150);
    };

    /* ── ESC key closes any open modal ── */
    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        ['testing-mode', 'toeic'].forEach(k => closeToggleModal(k));
        closeSignOutModal();
    });

    /* ── Chevron rotation observer ── */
    document.addEventListener('DOMContentLoaded', () => {
        const chevron = document.getElementById('navbar-user-chevron');
        if (dropdown && chevron) {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(m => {
                    if (dropdown.classList.contains('hidden')) {
                        chevron.classList.remove('rotate-180');
                    } else {
                        chevron.classList.add('rotate-180');
                    }
                });
            });
            observer.observe(dropdown, { attributes: true, attributeFilter: ['class'] });
        }
    });
</script>
