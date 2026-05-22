{{-- menghubungkan file main --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Petugas | Participants')

{{-- membuat content disini --}}
@section('content')

    {{-- konten --}}
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Participants Data Session 2</h1>

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
                <!-- search form -->
                <div class="w-full">
                    <form class="flex items-center" method="GET">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" name="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search" autocomplete="off">
                        </div>
                    </form>
                </div>
                {{-- end search --}}
                <div class="block lg:flex justify-end mt-5 ">
                    {{-- action --}}
                    <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover"
                        class="flex items-center text-black border-2 border-black font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
                        type="button">Action
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="overflow-x-auto w-full">
                        <!-- table data -->
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2">No</th>
                                    <th scope="col" class="px-4 py-3 border-2">Participants Name</th>
                                    <th scope="col" class="px-4 py-3 border-2">Participants Email</th>
                                    <th scope="col" class="px-4 py-3 border-2">Participants NIM</th>
                                    <th scope="col" class="px-4 py-3 border-2">Major</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Question Work Status
                                    </th>
                                    <th scope="col" class="px-4 py-3 border-2">Score Listening</th>
                                    <th scope="col" class="px-4 py-3 border-2">Score Reading</th>
                                    <th scope="col" class="px-4 py-3 border-2">Total Score</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peserta as $data)
                                    <tr class="border-b" id="baris{{ $loop->iteration }}">
                                        <th class="px-4 py-3 border-2">{{ $loop->iteration }}</th>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->nama_peserta }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->user->email }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->nim }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->jurusan }}</td>

                                        @if ($data->status == 'Sudah')
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">Done</td>
                                        @elseif ($data->status == 'Kerjain')
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">Work</td>
                                        @else
                                            <td class="px-4 py-3 border-2">Not yet</td>
                                        @endif

                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->skor_listening }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->skor_reading }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">
                                            {{ $data->skor_listening + $data->skor_reading }}
                                        </td>

                                        <td class="px-4 py-3 border-2 whitespace-nowrap text-center">
                                            <button id="dropdownMenuIconButton{{ $data->id_peserta }}" data-dropdown-toggle="dropdownDotsHorizontal{{ $data->id_peserta }}" data-dropdown-placement="left" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-700 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition duration-150 ease-in-out" type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                                </svg>
                                            </button>
                                            
                                            <!-- Dropdown menu -->
                                            <div id="dropdownDotsHorizontal{{ $data->id_peserta }}" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-56 dark:bg-gray-700 dark:divide-gray-600 border border-gray-200 text-left">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton{{ $data->id_peserta }}">
                                                    <li>
                                                        <button type="button" data-modal-target="UpdatePeserta{{ $data->id_peserta }}" data-modal-toggle="UpdatePeserta{{ $data->id_peserta }}" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                                            <i class="fa-solid fa-pen-to-square w-5 text-blue-500 mr-2 text-center"></i> 
                                                            <span class="font-medium text-gray-700 dark:text-gray-200">Update Participation</span>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/SendMail/Peserta/' . $data->id_peserta) }}" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                                            <i class="fa-solid fa-envelope w-5 text-green-500 mr-2 text-center"></i> 
                                                            <span class="font-medium text-gray-700 dark:text-gray-200">Send Mail</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/reset-default-password/' . $data->id_peserta) }}" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                                            <i class="fa-solid fa-key w-5 text-yellow-500 mr-2 text-center"></i> 
                                                            <span class="font-medium text-gray-700 dark:text-gray-200">Reset Password</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/reset-status-peserta-petugas/' . $data->id_peserta) }}" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                                            <i class="fa-solid fa-rotate-right w-5 text-orange-500 mr-2 text-center"></i> 
                                                            <span class="font-medium text-gray-700 dark:text-gray-200">Reset Status</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="py-1">
                                                    <button onclick="hapus('baris{{ $loop->iteration }}', '{{ $data->id_peserta }}')" type="button" data-modal-target="DeletePeserta" data-modal-toggle="DeletePeserta" class="flex items-center w-full px-4 py-2.5 text-red-600 hover:bg-red-50 dark:hover:bg-gray-600 dark:text-red-500 dark:hover:text-white transition-colors">
                                                        <i class="fa-solid fa-trash w-5 mr-2 text-center"></i> 
                                                        <span class="font-medium">Delete Participant</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="">
                    {{ $peserta->links() }}
                </div>
            </div>
        </div>
    </section>
    {{-- end konten --}}

    <!-- Dropdown button menu -->
    <div id="dropdownHover"
        class="relative z-20 hidden bg-white divide-y divide-gray-100 rounded-lg border-2 border-gray-300 w-44">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
            {{-- <li>
                <a href="{{ url('/SendMailPesertaAll/Sesione') }}"
                    class="block px-4 py-2 hover:bg-gray-100 text-green-300">Send Email</a>
            </li> --}}
            <li>
                <a href="{{ url('/ExportExcelPetugas/Sesione') }}" target="_blank"
                    class="block px-4 py-2 hover:bg-gray-100 text-sky-600">Export Data (Excel)</a>
            </li>
            <li>
                <a href="{{ url('/downloadresult/session_1') }}" target="_blank"
                    class="block px-4 py-2 hover:bg-gray-100 text-sky-600">Download Result (Zip)</a>
            </li>
            <li>
                <button type="button" data-modal-target="ResetStatus" data-modal-toggle="ResetStatus"
                    class="text-left w-full block px-4 py-2 hover:bg-gray-100 text-red-400">Reset Status Work</a>
            </li>
            <li>
                <button type="button" data-modal-target="DeleteAll" data-modal-toggle="DeleteAll"
                    class="text-left w-full block px-4 py-2 hover:bg-gray-100 text-red-600">Delete All Data</button>
            </li>
        </ul>
    </div>

    @foreach ($peserta as $data)
        {{-- Modal Update --}}
        <div id="UpdatePeserta{{ $data->id_peserta }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full p-4">
                <!-- Modal content -->
                <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Update Participants Data
                        </h3>
                        <button type="button"
                            class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                            data-modal-hide="UpdatePeserta{{ $data->id_peserta }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4 modal-form" action="{{ url('/UpdatePetugasPeserta') }}" method="POST">
                            @csrf

                            <input type="hidden" name="id_peserta" value="{{ $data->id_peserta }}">

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Full Name</label>
                                <input type="text" name="name" value="{{ $data->nama_peserta }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : Sopo Jarwo" required />
                            </div>

                            <div>
                                <label for="email" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Email</label>
                                <input type="email" name="email" value="{{ $data->user->email }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : youremail@gmail.com" required />
                            </div>

                            <div>
                                <label for="nim" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">NIM</label>
                                <input type="number" name="nim" value="{{ $data->nim }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : 221535000" required />
                                <p class=" text-red-600 text-xs mt-1" id="note"></p>
                            </div>

                            <div>
                                <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Participant Major</label>
                                <select id="countries" name="jurusan"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    <option value="{{ $data->jurusan }}" selected hidden>{{ $data->jurusan }}</option>
                                    <option value="Administrasi Bisnis">Administrasi Bisnis</option>
                                    <option value="Akutansi">Akutansi</option>
                                    <option value="Pariwisata">Pariwisata</option>
                                    <option value="Teknik Sipil">Teknik Sipil</option>
                                    <option value="Teknik Mesin">Teknik Mesin</option>
                                    <option value="Teknik Elektro">Teknik Elektro</option>
                                    <option value="Teknologi Informasi">Teknologi Informasi</option>
                                </select>
                            </div>

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Question Work
                                    Status</label>
                                <select id="countries" name="status"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    @if ($data->status == 'Sudah')
                                        <option selected hidden value="{{ $data->status }}">Done</option>
                                    @elseif ($data->status == 'Kerjain')
                                        <option selected hidden value="{{ $data->status }}">Work</option>
                                    @else
                                        <option selected hidden value="{{ $data->status }}">Not Yet</option>
                                    @endif
                                    <option value="Sudah">Done</option>
                                    <option value="Belum">Not yet</option>
                                </select>
                            </div>

                            <div>
                                <label for="name"
                                    class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Session</label>
                                <select id="countries" name="sesi"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    <option selected hidden value="{{ $data->sesi }}">{{ $data->sesi }}</option>
                                    <option value="Session 1">Session 1</option>
                                    <option value="Session 2">Session 2</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full text-white bg-sky-800 hover:bg-sky-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal Update --}}
    @endforeach

    {{-- Modal Delete --}}
    <div id="DeletePeserta" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="DeletePeserta">
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

                <h3 class="mb-2 text-lg font-bold text-gray-900">Delete Participant?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to delete this participant? This action cannot be undone and all their exam history will be permanently lost.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/DeletePetugasPeserta') }}" method="POST">
                        @csrf
                        <input type="hidden" id="hapus-peserta" name="id_peserta">

                        <button data-modal-toggle="DeletePeserta" type="button"
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



    {{-- Modal Reset Status --}}
    <div id="ResetStatus" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="ResetStatus">
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

                <h3 class="mb-2 text-lg font-bold text-gray-900">Reset All Exam Status?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to reset the exam status for all participants? They will be allowed to retake the test. This action cannot be undone.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/ResetStatusPetugas/Sesitwo') }}" method="POST">
                        @csrf

                        <button data-modal-toggle="ResetStatus" type="button"
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

    {{-- Modal Delete All --}}
    <div id="DeleteAll" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="DeleteAll">
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

                <h3 class="mb-2 text-lg font-bold text-gray-900">Delete All Participants?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to delete all participants? This will permanently erase all participant records and exam history. This action is irreversible.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/DeleteAllPetugas/Sesitwo') }}" method="POST">
                        @csrf

                        <button data-modal-toggle="DeleteAll" type="button"
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
    {{-- End Modal Delete All --}}

    <script>
        function hapus(baris, id) {
            const td = document.querySelectorAll('#' + baris + ' td');

            document.getElementById('hapus-peserta').value = id;
        }
    </script>



@endsection
