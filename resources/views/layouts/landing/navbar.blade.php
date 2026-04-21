<nav class="bg-white/85 backdrop-blur-lg backdrop-saturate-150 border-b border-blue-100/50 fixed w-full z-20 top-0 shadow-sm shadow-blue-900/5">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 no-underline">
            <img src="{{ asset('img/logo unit.png') }}" alt="Logo PNB"
                class="w-8 h-8 sm:w-9 sm:h-9 object-contain" loading="lazy" />
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-semibold text-slate-800 tracking-wide">TOEIC Assessment</span>
                <span class="text-xs text-slate-400 hidden sm:block">Politeknik Negeri Bali</span>
            </div>
        </a>

        {{-- Desktop Nav Links --}}
        <ul class="hidden md:flex items-center gap-7 list-none m-0 p-0">
            <li><a href="#home"    class="nav-link text-sm font-medium text-slate-500 no-underline hover:text-brand-accent transition-colors duration-150">Home</a></li>
            <li><a href="#about"   class="nav-link text-sm font-medium text-slate-500 no-underline hover:text-brand-accent transition-colors duration-150">About</a></li>
            {{-- Tutorial link — uncomment setelah video tersedia
            <li><a href="#tutorial" class="nav-link text-sm font-medium text-slate-500 no-underline hover:text-brand-accent transition-colors duration-150">Tutorial</a></li>
            --}}
            <li><a href="#contact" class="nav-link text-sm font-medium text-slate-500 no-underline hover:text-brand-accent transition-colors duration-150">Contact</a></li>
        </ul>

        {{-- Auth --}}
        <div class="flex items-center gap-2 sm:gap-3">
            @auth
                {{-- User Dropdown --}}
                <button id="user-menu-button" data-dropdown-toggle="dropdown-user"
                    class="flex items-center gap-2.5 px-2 py-1.5 rounded-xl hover:bg-slate-50 focus:ring-4 focus:ring-blue-50 transition-colors border border-transparent hover:border-slate-200 focus:outline-none">
                    <span class="sr-only">Open user menu</span>
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-slate-100 shadow-sm border border-slate-200">
                        <img class="w-full h-full object-cover" src="{{ asset('profile/profile.png') }}" alt="photo" loading="lazy" />
                    </div>
                    <div class="hidden md:flex flex-col text-left mr-1">
                        <span class="text-xs font-bold text-slate-700 leading-tight">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] text-slate-500 capitalize leading-tight">{{ auth()->user()->level }}</span>
                    </div>
                    <i id="landing-user-chevron" class="fa-solid fa-chevron-down text-xs text-slate-400 hidden md:block transition-transform duration-200"></i>
                </button>
                <div id="dropdown-user"
                    class="hidden z-50 w-56 text-base list-none bg-white/95 backdrop-blur-md rounded-xl divide-y divide-slate-100 shadow-xl border border-slate-100">
                    <div class="px-4 py-3 bg-slate-50/50 rounded-t-xl">
                        <span class="block text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</span>
                        <span class="block text-xs text-slate-500 truncate mt-0.5">{{ auth()->user()->email }}</span>
                    </div>
                    <ul class="py-1 text-sm text-slate-700">
                        @if(auth()->user()->level == 'admin')
                        <li><a href="{{ url('/admin') }}"   class="flex items-center px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 transition-colors"><i class="fa-solid fa-house w-6 text-slate-400 text-center"></i> Dashboard</a></li>
                        @elseif(auth()->user()->level == 'petugas')
                        <li><a href="{{ url('/petugas') }}" class="flex items-center px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 transition-colors"><i class="fa-solid fa-house w-6 text-slate-400 text-center"></i> Dashboard</a></li>
                        @else
                        <li><a href="{{ url('/peserta') }}" class="flex items-center px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 transition-colors"><i class="fa-solid fa-house w-6 text-slate-400 text-center"></i> Dashboard</a></li>
                        @endif
                    </ul>
                    <div class="py-1">
                        <button id="btn-landing-signout-trigger" onclick="openLandingSignOutModal()"
                            class="flex w-full items-center px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors text-left">
                            <i class="fa-solid fa-arrow-right-from-bracket w-6 text-red-500 text-center"></i> Sign out
                        </button>
                    </div>
                </div>
            @else
                <a href="{{ url('/login') }}"
                    class="bg-brand-accent hover:bg-brand-accent-hover text-white text-sm font-semibold px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl transition-all duration-200 no-underline shadow shadow-blue-500/20">
                    Sign In
                </a>
            @endauth

            {{-- Mobile Hamburger --}}
            <button data-collapse-toggle="navbar-mobile" type="button"
                class="md:hidden p-2 text-slate-500 rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fa-solid fa-bars text-base"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="navbar-mobile" class="hidden md:hidden border-t border-blue-100/40 bg-white/95 backdrop-blur-md">
        <ul class="list-none m-0 px-4 py-3 space-y-0.5">
            <li><a href="#home"    class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-blue-50 hover:text-brand-accent transition-colors">Home</a></li>
            <li><a href="#about"   class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-blue-50 hover:text-brand-accent transition-colors">About</a></li>
            {{-- <li><a href="#tutorial" class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-blue-50 hover:text-brand-accent transition-colors">Tutorial</a></li> --}}
            <li><a href="#contact"  class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-blue-50 hover:text-brand-accent transition-colors">Contact</a></li>
        </ul>
    </div>
</nav>

@auth
{{-- ══ Sign Out Confirmation Modal (Landing) ══ --}}
<div id="landing-signout-modal" class="fixed inset-0 z-[999] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-150 ease-out" aria-modal="true" role="dialog">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    {{-- Dialog Card --}}
    <div id="landing-signout-dialog" class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden w-full max-w-sm mx-4 transform scale-95 transition-transform duration-150 ease-out">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mb-4">
                <i class="fa-solid fa-arrow-right-from-bracket text-red-500 text-lg"></i>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900">Sign Out?</h3>
            <p class="mb-6 text-sm text-gray-500">Are you sure you want to sign out? You will need to sign in again to access your account.</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeLandingSignOutModal()" type="button" class="w-full py-2.5 text-sm font-semibold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <a href="{{ url('/logout') }}" class="w-full text-white bg-red-600 hover:bg-red-700 font-semibold rounded-xl text-sm inline-flex justify-center items-center py-2.5 transition-colors no-underline">
                    Yes, Sign Out
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const landingModal = document.getElementById('landing-signout-modal');
    const landingDialog = document.getElementById('landing-signout-dialog');
    const landingDropdown = document.getElementById('dropdown-user');
    
    window.openLandingSignOutModal = () => {
        // Hide dropdown
        if (landingDropdown) landingDropdown.classList.add('hidden');
        
        // Show modal smoothly
        landingModal.classList.remove('pointer-events-none');
        requestAnimationFrame(() => {
            landingModal.classList.replace('opacity-0', 'opacity-100');
            landingDialog.classList.replace('scale-95', 'scale-100');
        });
    };

    window.closeLandingSignOutModal = () => {
        landingModal.classList.replace('opacity-100', 'opacity-0');
        landingDialog.classList.replace('scale-100', 'scale-95');
        setTimeout(() => {
            landingModal.classList.add('pointer-events-none');
        }, 150); // Matches duration-150
    };

    document.addEventListener('DOMContentLoaded', () => {
        const chevron = document.getElementById('landing-user-chevron');

        // Observer pattern to watch Flowbite toggling classes for dropdown arrow
        if(landingDropdown && chevron) {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(m => {
                    if (landingDropdown.classList.contains('hidden')) {
                        chevron.classList.remove('rotate-180');
                    } else {
                        chevron.classList.add('rotate-180');
                    }
                });
            });
            observer.observe(landingDropdown, { attributes: true, attributeFilter: ['class'] });
        }
    });
</script>
@endauth
