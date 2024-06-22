    <!-- Sidebar -->
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
        aria-label="Sidenav" id="drawer-navigation">
        <div class="overflow-y-auto py-5 px-3 h-full bg-white">
            {{-- admin --}}
            @if (auth()->user()->level == 'admin')
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/admin') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-l hover:bg-gray-100">
                            <i class="fa-solid fa-house text-xl text-black"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <button type="button"
                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                            aria-controls="dropdown-user" data-collapse-toggle="dropdown-user">
                            <i class="fa-solid fa-user text-xl text-black"></i>
                            <span class="flex-1 ml-4 text-left whitespace-nowrap">User</span>
                            <i class="fa-solid fa-caret-down"></i>
                        </button>
                        <ul id="dropdown-user" class="hidden py-2 space-y-2">
                            <li>
                                <a href="{{ url('/dashPetugas') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-clipboard-user me-3"></i>
                                    Staff Data
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/dashPeserta') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-graduation-cap me-2"></i>
                                    Participants Data
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <button type="button"
                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                            aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                            <i class="fa-solid fa-book-atlas text-xl text-black"></i>
                            <span class="flex-1 ml-4 text-left whitespace-nowrap">Question</span>
                            <i class="fa-solid fa-caret-down"></i>
                        </button>
                        <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                            <li>
                                <a href="{{ url('/dashAdminGambar') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-image text-xl text-black"></i>
                                    <span class="ml-4">Image Question</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/dashAdminAudio') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-volume-high text-xl text-black"></i>
                                    <span class="ml-4">Audio Question</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/dashAdminSoal') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-vault text-xl text-black"></i>
                                    <span class="ml-4">Code Question</span>
                                </a>
                            </li>


                        </ul>
                    </li>

                </ul>

                {{-- Petugas --}}
            @elseif(auth()->user()->level == 'petugas')
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/petugas') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-l hover:bg-gray-100">
                            <i class="fa-solid fa-house text-xl text-black"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <button type="button"
                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                            aria-controls="dropdown-user" data-collapse-toggle="dropdown-user">
                            <i class="fa-solid fa-user text-xl text-black"></i>
                            <span class="flex-1 ml-4 text-left whitespace-nowrap">User</span>
                            <i class="fa-solid fa-caret-down"></i>
                        </button>
                        <ul id="dropdown-user" class="hidden py-2 space-y-2">
                            <li>
                                <a href="{{ url('/dashPetugasPeserta') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-graduation-cap me-2"></i>
                                    Participants Data
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <button type="button"
                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                            aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                            <i class="fa-solid fa-book-atlas text-xl text-black"></i>
                            <span class="flex-1 ml-4 text-left whitespace-nowrap">Question</span>
                            <i class="fa-solid fa-caret-down"></i>
                        </button>
                        <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                            <li>
                                <a href="{{ url('/dashPetugasGambar') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-image text-xl text-black"></i>
                                    <span class="ml-4">Image Question</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/dashPetugasAudio') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-volume-high text-xl text-black"></i>
                                    <span class="ml-4">Audio Question</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/dashPetugasSoal') }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                    <i class="fa-solid fa-vault text-xl text-black"></i>
                                    <span class="ml-4">Code Question</span>
                                </a>
                            </li>


                        </ul>
                    </li>

                </ul>
                {{-- peserta --}}
            @else
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/peserta') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-l hover:bg-gray-100">
                            <i class="fa-solid fa-house text-xl text-black"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/Profil') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-l hover:bg-gray-100">
                            <i class="fa-solid fa-user text-xl text-black"></i>
                            <span class="ml-4">Profile</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/DashboardSoal') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-l hover:bg-gray-100">
                            <i class="fa-solid fa-clipboard-question text-xl text-black"></i>
                            <span class="ml-4">Question</span>
                        </a>
                    </li>

                </ul>
            @endif


        </div>
    </aside>
