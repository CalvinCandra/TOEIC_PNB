@php
    $isAdmin = auth()->user()->level === 'admin';
    $isPetugas = auth()->user()->level === 'petugas';
    $isPeserta = auth()->user()->level === 'peserta';

    // Prefix URL berdasarkan level
    $urlHome = $isAdmin ? 'admin' : 'petugas';
    $urlUser = $isAdmin ? 'dashPeserta' : 'dashPetugasPeserta';
    $urlGambar = $isAdmin ? 'dashAdminGambar' : 'dashPetugasGambar';
    $urlAudio = $isAdmin ? 'dashAdminAudio' : 'dashPetugasAudio';
    $urlBankSoal = $isAdmin ? 'dashAdminSoal' : 'dashPetugasSoal';

    // Closure — tidak ada masalah redefinisi
    $isActive = fn(string|array $paths): bool => collect((array) $paths)->contains(
        fn($p) => request()->is(ltrim($p, '/')),
    );

    $activeClass = fn(string|array $paths): string => $isActive($paths)
        ? 'bg-brand/10 text-brand font-semibold'
        : 'text-gray-900 hover:bg-gray-100';

    // Cek apakah grup menu aktif (untuk auto-expand dropdown)
    $userPaths = array_merge(
        [$urlUser],
        array_map(fn($s) => $urlUser . $s, range(1, 2)),
        $isAdmin ? ['dashPetugas'] : [],
    );
    $questionPaths = [$urlGambar, $urlAudio, $urlBankSoal];
    $userMenuOpen = $isActive($userPaths);
    $questionMenuOpen = $isActive($questionPaths);
@endphp

<aside id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
    aria-label="Sidenav">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white">

        {{-- ══════ ADMIN & PETUGAS ══════ --}}
        @if ($isAdmin || $isPetugas)
            <ul class="space-y-2">

                {{-- Dashboard --}}
                <li>
                    <a href="{{ url("/{$urlHome}") }}"
                        class="flex items-center p-2 text-base font-medium rounded-lg {{ $activeClass($urlHome) }}">
                        <i class="fa-solid fa-house text-xl"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                {{-- Staff — Admin only --}}
                @if ($isAdmin)
                    <li>
                        <a href="{{ url('/dashPetugas') }}"
                            class="flex items-center p-2 text-base font-medium rounded-lg {{ $activeClass('dashPetugas') }}">
                            <i class="fa-solid fa-user-tie text-xl"></i>
                            <span class="ml-3">Staff</span>
                        </a>
                    </li>
                @endif

                {{-- Participants (dropdown) --}}
                <li>
                    <button type="button" aria-controls="dropdown-user" data-collapse-toggle="dropdown-user"
                        class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75
                        {{ $userMenuOpen ? 'bg-brand/10 text-brand font-semibold' : 'text-gray-900 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-user text-xl"></i>
                        <span class="flex-1 ml-4 text-left whitespace-nowrap">Peserta</span>
                        <i
                            class="fa-solid fa-caret-down {{ $userMenuOpen ? 'rotate-180' : '' }} transition-transform duration-200"></i>
                    </button>
                    <ul id="dropdown-user" class="{{ $userMenuOpen ? '' : 'hidden' }} py-2 space-y-2">
                        <li>
                            <a href="{{ url("/{$urlUser}") }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg {{ $activeClass($urlUser) }}">
                                All Data
                            </a>
                        </li>
                        @foreach (range(1, 2) as $s)
                            <li>
                                <a href="{{ url("/{$urlUser}{$s}") }}"
                                    class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg {{ $activeClass($urlUser . $s) }}">
                                    Session {{ $s }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Question (dropdown) --}}
                <li>
                    <button type="button" aria-controls="dropdown-question" data-collapse-toggle="dropdown-question"
                        class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75
                        {{ $questionMenuOpen ? 'bg-brand/10 text-brand font-semibold' : 'text-gray-900 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-book-atlas text-xl"></i>
                        <span class="flex-1 ml-4 text-left whitespace-nowrap">Question</span>
                        <i
                            class="fa-solid fa-caret-down {{ $questionMenuOpen ? 'rotate-180' : '' }} transition-transform duration-200"></i>
                    </button>
                    <ul id="dropdown-question" class="{{ $questionMenuOpen ? '' : 'hidden' }} py-2 space-y-2">
                        <li>
                            <a href="{{ url("/{$urlGambar}") }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg {{ $activeClass($urlGambar) }}">
                                Add Image
                            </a>
                        </li>
                        <li>
                            <a href="{{ url("/{$urlAudio}") }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg {{ $activeClass($urlAudio) }}">
                                Add Audio
                            </a>
                        </li>
                        <li>
                            <a href="{{ url("/{$urlBankSoal}") }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg {{ $activeClass($urlBankSoal) }}">
                                Bank Code
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            {{-- ══════ PESERTA ══════ --}}
        @else
            <ul class="space-y-2">
                <li>
                    <a href="{{ url('/peserta') }}"
                        class="flex items-center p-2 text-base font-medium rounded-lg {{ $activeClass('peserta') }}">
                        <i class="fa-solid fa-house text-xl"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/Profil') }}"
                        class="flex items-center p-2 text-base font-medium rounded-lg {{ $activeClass('Profil') }}">
                        <i class="fa-solid fa-user text-xl"></i>
                        <span class="ml-3">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/DashboardSoal') }}"
                        class="flex items-center p-2 text-base font-medium rounded-lg {{ $activeClass('DashboardSoal') }}">
                        <i class="fa-solid fa-pencil text-xl"></i>
                        <span class="ml-3">Take Exam</span>
                    </a>
                </li>
            </ul>
        @endif

    </div>
</aside>
