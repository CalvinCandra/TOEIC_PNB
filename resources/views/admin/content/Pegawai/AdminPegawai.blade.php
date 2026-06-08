{{-- menghubungkan file main --}}
@extends('admin.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Admin | Staff')

{{-- membuat content disini --}}
@section('content')
    {{-- konten --}}
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Staff Data</h1>

        <div class="p-3 sm:p-5 antialiased">
            @if (count($errors) > 0)
                <div id="alert-2" class="flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="ml-3 text-sm font-medium">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-3">
                <!-- live search -->
                @include('layouts.dashboard.live-search', ['placeholder' => 'Search by name, email...'])
                {{-- end search --}}
                <div class="flex justify-between mt-5">
                    <!-- Modal toggle -->
                    <button data-modal-target="TambahPetugas" data-modal-toggle="TambahPetugas"
                        class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
                        type="button">
                        Create Staff Data
                    </button>

                    <a href="{{ url('/SendMailPetugasAll') }}"
                        class="block text-white bg-green-400 hover:bg-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5 w-32"
                        type="button">
                        Send Email
                    </a>
                </div>
                <div id="search-results-container">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">

                    <div class="overflow-x-auto w-full">

                        <!-- table data -->
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2">No</th>
                                    <th scope="col" class="px-4 py-3 border-2">Staff Name</th>
                                    <th scope="col" class="px-4 py-3 border-2">Staff Email</th>
                                    <th scope="col" class="px-4 py-3 border-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petugas as $data)
                                    <tr class="border-b dark:border-gray-700" id="baris{{ $loop->iteration }}">
                                        <th class="px-4 py-3 border-2">{{ $loop->iteration }}</th>
                                        <td class="px-4 py-3 border-2">{{ $data->nama_petugas }}</td>
                                        <td class="px-4 py-3 border-2">{{ $data->user->email }}</td>
                                        <td class="px-4 py-3 border-2">
                                            <ul class="flex py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                <li>
                                                    <a href="{{ url('/SendMail/Petugas/' . $data->id_petugas) }}"
                                                        class="flex items-center w-full px-4 py-2 text-green-400 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-paper-plane me-1"></i>
                                                        Send Mail
                                                    </a>
                                                </li>
                                                <li>
                                                    <button
                                                        onclick="edit('baris{{ $loop->iteration }}', '{{ $data->id_petugas }}')"
                                                        type="button" data-modal-target="UpdatePetugas"
                                                        data-modal-toggle="UpdatePetugas"
                                                        class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-pen-to-square me-1 -mt-0.5"></i>
                                                        Update
                                                    </button>
                                                </li>
                                                <li>
                                                    <button
                                                        onclick="hapus('baris{{ $loop->iteration }}', '{{ $data->id_petugas }}')"
                                                        type="button" data-modal-target="DeletePetugas"
                                                        data-modal-toggle="DeletePetugas"
                                                        class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-trash me-1"></i>
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="">
                    {{ $petugas->links() }}
                </div>
                </div> {{-- end search-results-container --}}
            </div>
        </div>
    </section>
    {{-- end konten --}}

    {{-- Modal Tambah --}}
    <div id="TambahPetugas" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Create Staff Data
                    </h3>
                    <button type="button"
                        class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                        data-modal-hide="TambahPetugas">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4 modal-form" action="{{ url('/TambahPetugas') }}" method="POST">
                        @csrf

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Full Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : Sopo Jarwo" required />
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : youremail@gmail.com" required />
                        </div>

                        <button id="tambah" type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md hover:shadow-blue-600/20 active:scale-95 cursor-pointer mt-2">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah --}}

    {{-- Modal Update --}}
    <div id="UpdatePetugas" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Update Staff Data
                    </h3>
                    <button type="button"
                        class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                        data-modal-hide="UpdatePetugas">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4 modal-form" action="{{ url('/UpdatePetugas') }}" method="POST">
                        @csrf

                        <input type="hidden" name="id_petugas" id="edit-petugas">

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Full Name</label>
                            <input type="text" name="name" id="edit-name"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : Sopo Jarwo" required />
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Email</label>
                            <input type="email" name="email" id="edit-email"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : youremail@gmail.com" required />
                        </div>

                        <button id="update" type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md hover:shadow-blue-600/20 active:scale-95 cursor-pointer mt-2">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Update --}}

    {{-- Modal Delete --}}
    <div id="DeletePetugas" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="DeletePetugas">
                    <svg aria-hidden="true" class="w-3 h-3" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mb-4">
                    <i class="fa-solid fa-trash text-red-500 text-lg"></i>
                </div>

                <h3 class="mb-2 text-lg font-bold text-gray-900">Delete Staff Member?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to delete this staff member? This action cannot be undone and their access rights will be immediately revoked.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/DeletePetugas') }}" method="POST">
                        @csrf
                        <input type="hidden" id="hapus-petugas" name="id_petugas">

                        <button data-modal-toggle="DeletePetugas" type="button"
                            class="w-full py-2.5 text-sm font-semibold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors outline-none cursor-pointer text-center">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full py-2.5 text-sm font-semibold text-center text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors outline-none cursor-pointer text-center">
                            Yes, Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Delete --}}

    <script>
        function edit(baris, id) {
            const td = document.querySelectorAll('#' + baris + ' td');

            document.getElementById('edit-name').value = td[0].innerText
            document.getElementById('edit-email').value = td[1].innerText

            document.getElementById('edit-petugas').value = id;
        }

        function hapus(baris, id) {
            const td = document.querySelectorAll('#' + baris + ' td');

            document.getElementById('hapus-petugas').value = id;
        }
    </script>
@endsection
