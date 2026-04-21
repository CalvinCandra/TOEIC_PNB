{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Peserta | Profile')

{{-- membuat content disini --}}
@section('content')

    <main class="p-5 md:ml-64 md:px-8 lg:px-12 h-auto pt-20">
        <div class="my-6 max-w-4xl mx-auto">

            @if (count($errors) > 0)
                <div class="flex p-4 mb-6 text-red-800 rounded-xl bg-red-50 border border-red-100" role="alert">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 mr-3"></i>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm font-medium">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Participant Profile</h1>
                <p class="text-gray-500 mt-2 text-sm max-w-2xl">Please review your profile below. Edit the data if necessary.
                    This information will be printed and shown on your official score report.</p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100">
                <div class="p-8 md:p-10">
                    <form id="profilForm" action="{{ url('/UpdateProfil') }}" method="POST">
                        @csrf
                        <div class="grid gap-6 md:grid-cols-2">

                            {{-- Name --}}
                            <div class="md:col-span-2">
                                <label for="name" class="block mb-2 text-sm font-semibold text-gray-800">Full
                                    Name</label>
                                <input type="text" name="name" id="name" value="{{ $peserta->nama_peserta }}"
                                    class="bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 transition-colors"
                                    required>
                            </div>

                            {{-- Email (Disabled) --}}
                            <div>
                                <label for="email" class="block mb-2 text-sm font-semibold text-gray-800">Email
                                    Address</label>
                                <div class="relative">
                                    <input type="email" name="email" id="email" value="{{ $peserta->user->email }}"
                                        disabled
                                        class="bg-gray-100/70 border border-slate-200 text-gray-500 text-sm rounded-xl block w-full p-3.5 cursor-not-allowed">
                                    <i class="fa-solid fa-lock absolute right-4 top-4 text-gray-400 text-sm"></i>
                                </div>
                            </div>

                            {{-- NIM --}}
                            <div>
                                <label for="nim" class="block mb-2 text-sm font-semibold text-gray-800">NIM (Student
                                    ID)</label>
                                <input type="text" name="nim" id="nim" value="{{ $peserta->nim }}"
                                    class="bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 transition-colors"
                                    required>
                            </div>

                            {{-- Category / Jurusan --}}
                            <div class="md:col-span-2 relative">
                                <label class="block mb-2 text-sm font-semibold text-gray-800">Major</label>

                                {{-- Hidden Native Select for Form Submission --}}
                                <select id="real-jurusan-select" name="jurusan" class="hidden">
                                    <option value="{{ $peserta->jurusan }}" selected>{{ $peserta->jurusan }}</option>
                                    <option value="Akutansi">Akuntansi</option>
                                    <option value="Administrasi Bisnis">Administrasi Bisnis</option>
                                    <option value="Pariwisata">Pariwisata</option>
                                    <option value="Teknik Sipil">Teknik Sipil</option>
                                    <option value="Teknik Mesin">Teknik Mesin</option>
                                    <option value="Teknik Elektro">Teknik Elektro</option>
                                    <option value="Teknologi Informasi">Teknologi Informasi</option>
                                </select>

                                {{-- Custom Dropdown UI --}}
                                <div class="relative w-full text-left" id="custom-dropdown-wrapper">
                                    <button type="button" id="custom-dropdown-btn"
                                        class="flex justify-between items-center bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 w-full p-3.5 transition-all duration-300 cursor-pointer shadow-sm">
                                        <span id="custom-dropdown-text"
                                            class="font-medium truncate">{{ $peserta->jurusan }}</span>
                                        <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300"
                                            id="custom-dropdown-arrow"></i>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div id="custom-dropdown-menu"
                                        class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl opacity-0 invisible translate-y-1 transition-all duration-200 pointer-events-none transform origin-top-right overflow-hidden">
                                        <ul class="py-1 text-sm text-gray-700 max-h-60 overflow-y-auto">
                                            @foreach (['Akutansi' => 'Akuntansi', 'Pariwisata' => 'Pariwisata', 'Teknik Sipil' => 'Teknik Sipil', 'Teknik Mesin' => 'Teknik Mesin', 'Teknik Elektro' => 'Teknik Elektro', 'Teknologi Informasi' => 'Teknologi Informasi'] as $val => $label)
                                                <li>
                                                    <button type="button"
                                                        class="w-full text-left px-5 py-3 hover:bg-blue-50 hover:text-blue-700 transition-colors font-medium text-slate-600 flex items-center gap-2 custom-opt-btn"
                                                        data-value="{{ $val }}" data-label="{{ $label }}">
                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full {{ $peserta->jurusan == $val ? 'bg-blue-500' : 'bg-transparent' }} opt-indicator"></span>
                                                        {{ $label }}
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end">
                            <button type="button" onclick="openConfirmModal()"
                                class="inline-flex items-center px-6 py-3 text-sm font-bold text-center text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 shadow-md hover:shadow-blue-600/30 active:scale-95">
                                Save Changes <i class="fa-solid fa-check ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    {{-- ══ Confirm Save Modal ══ --}}
    <div id="confirm-modal"
        class="fixed inset-0 z-[999] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-150 ease-out"
        aria-modal="true" role="dialog">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

        {{-- Dialog Card --}}
        <div id="confirm-dialog"
            class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden w-full max-w-sm mx-4 transform scale-95 transition-transform duration-150 ease-out">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 mb-4">
                    <i class="fa-solid fa-floppy-disk text-blue-600 text-xl"></i>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900">Save Changes?</h3>
                <p class="mb-6 text-sm text-gray-500">Are you sure you want to save the new profile data? This information
                    will be used for your official records.</p>
                <div class="flex justify-center gap-3">
                    <button onclick="closeConfirmModal()" type="button"
                        class="w-full py-2.5 text-sm font-semibold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitProfilForm()" type="button"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 font-semibold rounded-xl text-sm inline-flex justify-center items-center py-2.5 transition-colors no-underline">
                        Yes, Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Dropdown Interaction Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('custom-dropdown-wrapper');
            const btn = document.getElementById('custom-dropdown-btn');
            const menu = document.getElementById('custom-dropdown-menu');
            const arrow = document.getElementById('custom-dropdown-arrow');
            const text = document.getElementById('custom-dropdown-text');
            const realSelect = document.getElementById('real-jurusan-select');
            const optionBtns = document.querySelectorAll('.custom-opt-btn');

            let isOpen = false;

            const toggleDropdown = () => {
                isOpen = !isOpen;
                if (isOpen) {
                    menu.classList.remove('opacity-0', 'invisible', 'translate-y-1', 'pointer-events-none');
                    menu.classList.add('opacity-100', 'visible', 'translate-y-0', 'pointer-events-auto');
                    arrow.classList.add('rotate-180');
                    btn.classList.add('border-blue-500', 'ring-4', 'ring-blue-100', 'bg-white');
                    btn.classList.remove('bg-slate-50', 'border-slate-200');
                } else {
                    menu.classList.add('opacity-0', 'invisible', 'translate-y-1', 'pointer-events-none');
                    menu.classList.remove('opacity-100', 'visible', 'translate-y-0', 'pointer-events-auto');
                    arrow.classList.remove('rotate-180');
                    btn.classList.remove('border-blue-500', 'ring-4', 'ring-blue-100', 'bg-white');
                    btn.classList.add('bg-slate-50', 'border-slate-200');
                }
            };

            btn.addEventListener('click', toggleDropdown);

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target) && isOpen) {
                    toggleDropdown();
                }
            });

            // Handle option selection
            optionBtns.forEach(optBtn => {
                optBtn.addEventListener('click', (e) => {
                    const val = optBtn.getAttribute('data-value');
                    const label = optBtn.getAttribute('data-label');

                    // Update Text
                    text.textContent = label;

                    // Update Real Select Form Value
                    realSelect.value = val;

                    // Update Indicators dots
                    document.querySelectorAll('.opt-indicator').forEach(ind => ind.classList.remove(
                        'bg-blue-500'));
                    document.querySelectorAll('.opt-indicator').forEach(ind => ind.classList.add(
                        'bg-transparent'));
                    optBtn.querySelector('.opt-indicator').classList.add('bg-blue-500');
                    optBtn.querySelector('.opt-indicator').classList.remove('bg-transparent');

                    toggleDropdown();
                });
            });
        });

        // Modal Logic
        const confirmModal = document.getElementById('confirm-modal');
        const confirmDialog = document.getElementById('confirm-dialog');
        const profilForm = document.getElementById('profilForm');

        window.openConfirmModal = () => {
            // Validasi html form bawaan jika diperlukan, kalau fail jangan buka
            if (!profilForm.reportValidity()) return;

            confirmModal.classList.remove('pointer-events-none');
            requestAnimationFrame(() => {
                confirmModal.classList.replace('opacity-0', 'opacity-100');
                confirmDialog.classList.replace('scale-95', 'scale-100');
            });
        };

        window.closeConfirmModal = () => {
            confirmModal.classList.replace('opacity-100', 'opacity-0');
            confirmDialog.classList.replace('scale-100', 'scale-95');
            setTimeout(() => {
                confirmModal.classList.add('pointer-events-none');
            }, 150);
        };

        window.submitProfilForm = () => {
            // Tampilkan loading overlay jika ada sebelum submit (opsional)
            const overlay = document.getElementById('overlay');
            if (overlay) overlay.style.display = 'flex';

            closeConfirmModal();
            profilForm.submit();
        };
    </script>
@endsection
