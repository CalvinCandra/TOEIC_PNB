<nav class="bg-white border-b border-gray-100 fixed w-full z-20 top-0">
    <div class="max-w-screen-xl mx-auto px-4 lg:px-8 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
            <img src="{{ asset('img/logo unit.png') }}" alt="Logo PNB"
                class="w-9 h-9 object-contain" loading="lazy" />
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-semibold text-slate-800 tracking-wide">TOEIC Assessment</span>
                <span class="text-xs text-slate-500">Politeknik Negeri Bali</span>
            </div>
        </a>

        {{-- Desktop Nav Links --}}
        <ul class="hidden md:flex items-center gap-8 list-none m-0 p-0">
            <li><a href="#home"    class="nav-link text-base font-normal text-slate-600 no-underline hover:text-brand transition-colors">Home</a></li>
            <li><a href="#about"   class="nav-link text-base font-normal text-slate-600 no-underline hover:text-brand transition-colors">About</a></li>
            <li><a href="#tutorial" class="nav-link text-base font-normal text-slate-600 no-underline hover:text-brand transition-colors">Tutorial</a></li>
            <li><a href="#contact" class="nav-link text-base font-normal text-slate-600 no-underline hover:text-brand transition-colors">Contact</a></li>
        </ul>

        {{-- Auth --}}
        <div class="flex items-center gap-3">
            @auth
                {{-- User Dropdown --}}
                <button id="user-menu-button" data-dropdown-toggle="dropdown-user"
                    class="flex items-center gap-2 text-sm text-slate-700 focus:outline-none">
                    <img src="{{ asset('profile/profile.png') }}" alt="photo"
                        class="w-8 h-8 rounded-full object-cover border border-slate-200" />
                    <span class="hidden md:inline font-medium">{{ auth()->user()->name }}</span>
                    <i class="fa-solid fa-caret-down text-xs text-slate-400"></i>
                </button>
                <div id="dropdown-user"
                    class="hidden z-50 w-52 bg-white divide-y divide-gray-100 rounded-xl shadow-lg border border-gray-100">
                    <div class="px-4 py-3">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <ul class="py-1 text-sm text-slate-700">
                        @if(auth()->user()->level == 'admin')
                        <li><a href="{{ url('/admin') }}" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a></li>
                        @elseif(auth()->user()->level == 'petugas')
                        <li><a href="{{ url('/petugas') }}" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a></li>
                        @else
                        <li><a href="{{ url('/peserta') }}" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a></li>
                        @endif
                        <li><a href="{{ url('/logout') }}" class="block px-4 py-2 text-red-500 hover:bg-gray-50 font-medium">Sign out</a></li>
                    </ul>
                </div>
            @else
                <a href="{{ url('/login') }}"
                    class="bg-brand hover:bg-brand-hover text-white text-base font-normal px-5 py-2.5 rounded-lg transition-colors no-underline">
                    Sign In
                </a>
            @endauth

            {{-- Mobile Hamburger --}}
            <button data-collapse-toggle="navbar-mobile" type="button"
                class="md:hidden p-2 text-slate-600 rounded-lg hover:bg-gray-100">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="navbar-mobile" class="hidden md:hidden border-t border-gray-100 bg-white">
        <ul class="list-none m-0 p-4 space-y-1">
            <li><a href="#home"     class="block px-3 py-2 text-base font-normal text-slate-700 rounded-lg hover:bg-gray-50">Home</a></li>
            <li><a href="#about"    class="block px-3 py-2 text-base font-normal text-slate-700 rounded-lg hover:bg-gray-50">About</a></li>
            <li><a href="#tutorial" class="block px-3 py-2 text-base font-normal text-slate-700 rounded-lg hover:bg-gray-50">Tutorial</a></li>
            <li><a href="#contact"  class="block px-3 py-2 text-base font-normal text-slate-700 rounded-lg hover:bg-gray-50">Contact</a></li>
        </ul>
    </div>
</nav>
