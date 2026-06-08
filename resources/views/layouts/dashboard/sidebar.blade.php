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
        ? 'bg-blue-50 text-blue-700 font-bold border-r-4 border-blue-600'
        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-r-4 border-transparent font-medium';

    // Get unique sessions from database
    $sessions = \Illuminate\Support\Facades\DB::table('peserta')
        ->whereNotNull('sesi')
        ->distinct()
        ->pluck('sesi')
        ->sort()
        ->values()
        ->toArray();

    // Cek apakah grup menu aktif (untuk auto-expand dropdown)
    $userPaths = array_merge(
        [$urlUser],
        array_map(fn($s) => $urlUser . 'Sesi/' . rawurlencode($s), $sessions),
    );
    $questionPaths = [$urlGambar, $urlAudio, $urlBankSoal];
    $userMenuOpen = $isActive($userPaths);
    $questionMenuOpen = $isActive($questionPaths);
@endphp

<aside id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
    aria-label="Sidenav">
    <div class="flex flex-col h-full bg-white justify-between">
        <div class="overflow-y-auto py-5 px-3 flex-1">

            {{-- ══════ ADMIN & PETUGAS ══════ --}}
            @if ($isAdmin || $isPetugas)
                <ul class="space-y-3 font-medium mt-4">
                    <li class="px-3">
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-widest pl-2 mb-2">Main Menu</div>
                    </li>

                    {{-- Dashboard --}}
                    <li>
                        <a href="{{ url("/{$urlHome}") }}"
                            class="flex items-center px-4 py-2.5 text-sm rounded-xl {{ $activeClass($urlHome) }} transition-colors">
                            <i class="fa-solid fa-house w-5 text-center text-lg"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>

                    {{-- Staff — Admin only --}}
                    @if ($isAdmin)
                        <li>
                            <a href="{{ url('/dashPetugas') }}"
                                class="flex items-center px-4 py-2.5 text-sm rounded-xl {{ $activeClass('dashPetugas') }} transition-colors">
                                <i class="fa-solid fa-user-tie w-5 text-center text-lg"></i>
                                <span class="ml-3">Staff</span>
                            </a>
                        </li>
                    @endif

                    {{-- Participants (dropdown) --}}
                    <li>
                        <button type="button" aria-controls="dropdown-user" data-collapse-toggle="dropdown-user"
                            class="flex items-center px-4 py-2.5 w-full text-sm font-medium rounded-xl transition duration-75
                            {{ $userMenuOpen ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                            <i class="fa-solid fa-user w-5 text-center text-lg"></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">Participants</span>
                            <i
                                class="fa-solid fa-caret-down {{ $userMenuOpen ? 'rotate-180' : '' }} transition-transform duration-200"></i>
                        </button>
                        <ul id="dropdown-user" class="{{ $userMenuOpen ? '' : 'hidden' }} py-2 space-y-1">
                            <li>
                                <a href="{{ url("/{$urlUser}") }}"
                                    class="flex items-center px-4 py-2.5 pl-12 w-full text-sm font-medium rounded-xl {{ $activeClass($urlUser) }} transition-colors">
                                    All Data
                                </a>
                            </li>
                            @foreach ($sessions as $s)
                                <li>
                                    <a href="{{ url("/{$urlUser}Sesi/" . rawurlencode($s)) }}"
                                        class="flex items-center px-4 py-2.5 pl-12 w-full text-sm font-medium rounded-xl {{ $activeClass($urlUser . 'Sesi/' . rawurlencode($s)) }} transition-colors">
                                        {{ $s }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    {{-- Question (dropdown) --}}
                    <li>
                        <button type="button" aria-controls="dropdown-question" data-collapse-toggle="dropdown-question"
                            class="flex items-center px-4 py-2.5 w-full text-sm font-medium rounded-xl transition duration-75
                            {{ $questionMenuOpen ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                            <i class="fa-solid fa-book-atlas w-5 text-center text-lg"></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">Question</span>
                            <i
                                class="fa-solid fa-caret-down {{ $questionMenuOpen ? 'rotate-180' : '' }} transition-transform duration-200"></i>
                        </button>
                        <ul id="dropdown-question" class="{{ $questionMenuOpen ? '' : 'hidden' }} py-2 space-y-1">
                            <li>
                                <a href="{{ url("/{$urlGambar}") }}"
                                    class="flex items-center px-4 py-2.5 pl-12 w-full text-sm font-medium rounded-xl {{ $activeClass($urlGambar) }} transition-colors">
                                    Add Image
                                </a>
                            </li>
                            <li>
                                <a href="{{ url("/{$urlAudio}") }}"
                                    class="flex items-center px-4 py-2.5 pl-12 w-full text-sm font-medium rounded-xl {{ $activeClass($urlAudio) }} transition-colors">
                                    Add Audio
                                </a>
                            </li>
                            <li>
                                <a href="{{ url("/{$urlBankSoal}") }}"
                                    class="flex items-center px-4 py-2.5 pl-12 w-full text-sm font-medium rounded-xl {{ $activeClass($urlBankSoal) }} transition-colors">
                                    Bank Code
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Self Study History (menu tunggal) --}}
                    @php
                        $rolePrefix = Auth::user()->level === 'admin' ? 'Admin' : 'Petugas';
                    @endphp
                    <li>
                        <a href="{{ url("/dash{$rolePrefix}SelfStudyHistoryPeserta") }}"
                            class="flex items-center px-4 py-2.5 text-sm rounded-xl {{ $activeClass("dash{$rolePrefix}SelfStudyHistoryPeserta*") }} transition-colors">
                            <i class="fa-solid fa-history w-5 text-center text-lg"></i>
                            <span class="ml-3">Self Study History</span>
                        </a>
                    </li>

                </ul>

                {{-- ══════ PESERTA ══════ --}}
            @else
                <ul class="space-y-3 font-medium mt-4">
                    <li class="px-3">
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-widest pl-2 mb-2">Main Menu</div>
                    </li>
                    <li>
                        <a href="{{ url('/peserta') }}"
                            class="flex items-center px-4 py-2.5 text-sm rounded-xl {{ $activeClass('peserta') }} transition-colors">
                            <i class="fa-solid fa-house w-5 text-center text-lg"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/Profil') }}"
                            class="flex items-center px-4 py-2.5 text-sm rounded-xl {{ $activeClass('Profil') }} transition-colors">
                            <i class="fa-solid fa-user w-5 text-center text-lg"></i>
                            <span class="ml-3">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/DashboardSoal') }}"
                            class="flex items-center px-4 py-2.5 text-sm rounded-xl {{ $activeClass('DashboardSoal') }} transition-colors">
                            <i class="fa-solid fa-pencil w-5 text-center text-lg"></i>
                            <span class="ml-3">Take Exam</span>
                        </a>
                    </li>
                </ul>
            @endif

        </div>

        {{-- App Version --}}
        <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-400 select-none">
            <span class="font-medium">App Version</span>
            <span class="font-semibold text-slate-600 bg-slate-200/50 px-2 py-0.5 rounded-md">v{{ config('app.version', '1.0.0') }}</span>
        </div>
    </div>
</aside>
