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
                    <span class="text-[10px] text-slate-500 capitalize leading-tight">{{ auth()->user()->level }}</span>
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
    const modal = document.getElementById('signout-modal');
    const dialog = document.getElementById('signout-dialog');
    const dropdown = document.getElementById('dropdown');

    window.openSignOutModal = () => {
        // Hide dropdown
        if (dropdown) dropdown.classList.add('hidden');

        // Show modal smoothly
        modal.classList.remove('pointer-events-none');
        requestAnimationFrame(() => {
            modal.classList.replace('opacity-0', 'opacity-100');
            dialog.classList.replace('scale-95', 'scale-100');
        });
    };

    window.closeSignOutModal = () => {
        modal.classList.replace('opacity-100', 'opacity-0');
        dialog.classList.replace('scale-100', 'scale-95');
        setTimeout(() => {
            modal.classList.add('pointer-events-none');
        }, 150); // Matches duration-150
    };

    document.addEventListener('DOMContentLoaded', () => {
        const chevron = document.getElementById('navbar-user-chevron');

        // Observer pattern to watch Flowbite toggling classes for dropdown arrow
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
            observer.observe(dropdown, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
    });
</script>
