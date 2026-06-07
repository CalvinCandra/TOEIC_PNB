{{-- menghubungkan file main --}}
@extends('admin.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Admin | Participants')

{{-- membuat content disini --}}
@section('content')

    {{-- konten --}}
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Participants Data</h1>

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
            @if (session('gagal'))
                <div id="alert-2" class="flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <ul>
                        <li class="ml-3 text-sm font-medium">{{ session('gagal') }}</li>
                    </ul>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-3">
                <!-- live search -->
                @include('layouts.dashboard.live-search', ['placeholder' => 'Search by name, NIM, major...'])
                {{-- end search --}}
                <div class="block lg:flex justify-between mt-5 ">
                    <!-- Modal toggle -->
                    <div class="flex-warp lg:flex">
                        <button data-modal-target="TambahPesertaExcel" data-modal-toggle="TambahPesertaExcel"
                            class="lg:mx-2 block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
                            type="button">
                            Create With Excel
                        </button>

                        <a href="{{ url('/downloadtemplate') }}"
                            class="text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-sm px-5 flex items-center text-center mb-5"
                            target="_blank">
                            Download Template
                        </a>
                    </div>
                </div>

                <div id="search-results-container">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="overflow-x-auto w-full">
                        <!-- table data -->
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2">No</th>
                                    <th scope="col" class="px-4 py-3 border-2">Participants Name</th>
                                    <th scope="col" class="px-4 py-3 border-2">Participants NIM</th>
                                    <th scope="col" class="px-4 py-3 border-2">Major</th>
                                    <th scope="col" class="px-4 py-3 border-2">Session</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Date of Birth</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Password Status</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Question Work Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peserta as $data)
                                    <tr class="border-b" id="baris{{ $loop->iteration }}">
                                        <th class="px-4 py-3 border-2">{{ $loop->iteration }}</th>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->nama_peserta }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->nim }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->jurusan }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->sesi }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->tanggal_lahir }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->user->is_password_changed ? 'Changed' : 'Not Change' }}</td>

                                        @if ($data->status == 'Sudah')
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">Done</td>
                                        @else
                                            <td class="px-4 py-3 border-2">Not yet</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="">
                    {{ $peserta->links() }}
                </div>
                </div> {{-- end search-results-container --}}
            </div>
        </div>
    </section>
    {{-- end konten --}}

    {{-- Modal Tambah Excel --}}
    <div id="TambahPesertaExcel" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Create Participants Data
                    </h3>
                    <button type="button"
                        class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                        data-modal-hide="TambahPesertaExcel">
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
                    <form class="space-y-4 modal-form" action="{{ url('/TambahPesertaExcelAdmin') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file_input">File Excel</label>
                            <input accept="" name="file"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" type="file" required>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md hover:shadow-blue-600/20 active:scale-95 cursor-pointer mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah Excel --}}



@endsection
