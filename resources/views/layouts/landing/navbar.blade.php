{{-- Navbar --}}
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/PNB.png') }}" class="h-10" alt="PNB Logo">
            <div class="flex flex-col items-center">
                <span class="block text-base font-bold whitespace-nowrap dark:text-white flex-grow flex-basis-0">TOEIC
                    ASSESSMENT</span>
                <span class="block text-base text-gray-500 flex-grow flex-basis-0">Politeknik Negeri Bali</span>
            </div>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @auth
                <div class="hidden md:flex items-center lg:order-2">
                    <button type="button"
                        class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                        <span class="sr-only">Open user menu</span>
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-white shadow-md">
                            <img class="w-full" src="{{ asset('profile/profile.png') }}" alt="user photo" loading="lazy" />
                        </div>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="hidden z-50 my-4 w-56 text-base list-none bg-white divide-y divide-gray-100 shadow "
                        id="dropdown">
                        <div class="py-3 px-4">
                            <span class="block text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                            <span class="block text-sm text-gray-900 truncate">{{ auth()->user()->email }}</span>
                        </div>
                        <ul class="py-1 text-gray-700" aria-labelledby="dropdown">
                            {{-- pemilihan dashboard sesuai level --}}
                            <li>
                                <a @if (auth()->user()->level == 'admin') href="{{ url('/admin') }}"
                                @elseif (auth()->user()->level == 'petugas') href="{{ url('/petugas') }}"
                                @elseif (auth()->user()->level == 'peserta') href="{{ url('/peserta') }}" @endif
                                    class="block py-2 px-4 text-sm hover:bg-gray-100">Dashboard</a>
                            </li>

                            <li>
                                <a href="{{ url('/logout') }}"
                                    class="block py-2 px-4 text-sm font-bold hover:bg-gray-100">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <button type="button"
                    class="text-white bg-[#219EBC] hover:bg-[#1C89A4] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    onclick="window.location.href='/login'">Sign In</button>
            @endauth
            <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="#home" id="nav-home" class="nav-link block py-2 px-3 rounded md:p-0">Home</a>
                </li>
                <li>
                    <a href="#about" id="nav-about" class="nav-link block py-2 px-3 rounded md:p-0">About</a>
                </li>
                <li>
                    <a href="#contact" id="nav-contact" class="nav-link block py-2 px-3 rounded md:p-0">Contact</a>
                </li>
                @auth
                    <li class="block md:hidden mt-4 mb-3 ml-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-white shadow-md">
                                <img class="w-full" src="{{ asset('profile/profile.png') }}" alt="user photo"
                                    loading="lazy" />
                            </div>
                            <div>
                                <span class="block text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                                <span class="block text-sm text-gray-900 truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </li>

                    {{-- pemilihan dashboard sesuai level --}}
                    <li class="block md:hidden mt-3">
                        <a @if (auth()->user()->level == 'admin') href="{{ url('/admin') }}"
                        @elseif (auth()->user()->level == 'petugas') href="{{ url('/petugas') }}"
                        @elseif (auth()->user()->level == 'peserta') href="{{ url('/peserta') }}" @endif
                            class="block py-2 px-3 hover:bg-gray-100">Dashboard</a>
                    </li>

                    <li class="block md:hidden">
                        <a href="{{ url('/logout') }}"
                            class="block py-2 px-3 rounded font-bold text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 md:dark:hover:text-blue-500">Sign
                            Out</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
