{{-- menghubungkan file main --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Staff | Question')

{{-- membuat content disini --}}
@section('content')

    {{-- konten --}}
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Bank Question Data</h1>

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
                <div class="flex justify-between mt-5">
                    <!-- Modal toggle -->
                    <button data-modal-target="TambahBankSoal" data-modal-toggle="TambahBankSoal"
                        class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
                        type="button">
                        Create Bank Question
                    </button>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="overflow-x-auto w-full">
                        <!-- table data -->
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2">No</th>
                                    <th scope="col" class="px-4 py-3 border-2">Code Question</th>
                                    <th scope="col" class="px-4 py-3 border-2">Session</th>
                                    <th scope="col" class="px-4 py-3 border-2">Mode</th>
                                    <th scope="col" class="px-4 py-3 border-2">Start Time</th>
                                    <th scope="col" class="px-4 py-3 border-2">End Time</th>
                                    <th scope="col" class="px-4 py-3 border-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bank as $data)
                                    <tr class="border-b" id="baris{{ $loop->iteration }}">
                                        <th class="px-4 py-3 border-2">{{ $loop->iteration }}</th>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->bank }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">
                                            @if($data->mode === 'self_study')
                                                <span class="text-xs text-gray-400 italic">— (Self Study)</span>
                                            @else
                                                {{ $data->sesi_bank }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">
                                            <span class="text-xs font-semibold px-2 py-1 rounded
                                                {{ $data->mode === 'toeic' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                                {{ $data->mode === 'toeic' ? 'TOEIC' : 'Self Study' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->waktu_mulai }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->waktu_akhir }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">
                                            <ul class="lg:block py-1 text-sm"
                                                aria-labelledby="apple-imac-27-dropdown-button">

                                                <h1 class="font-semibold text-md">For Listening :</h1>
                                                <li class="lg:flex">
                                                    <div class="">
                                                        <a href="{{ url('/dashPetugasPartListening' . '/' . $data->id_bank) }}"
                                                            class="flex items-center w-full px-4 py-2 text-purple-700
                                                    hover:bg-gray-100 hover:scale-95">
                                                            <i class="fa-solid fa-plus me-1"></i>
                                                            Add Part Listening
                                                        </a>
                                                    </div>

                                                    <div class="">
                                                        <a href="{{ url('/dashPetugasSoalDetailListening' . '/' . $data->id_bank) }}"
                                                            class="flex items-center w-full px-4 py-2 text-purple-700
                                                    hover:bg-gray-100 hover:scale-95">
                                                            <i class="fa-solid fa-clipboard-question me-1"></i>
                                                            Add Question Listening
                                                        </a>
                                                    </div>
                                                </li>

                                                <h1 class="font-semibold text-md mt-3">For Reading :</h1>
                                                <li class="lg:flex">
                                                    <div class="">
                                                        <a href="{{ url('/dashPetugasPartReading' . '/' . $data->id_bank) }}"
                                                            class="flex items-center w-full px-4 py-2 text-yellow-300
                                                    hover:bg-gray-100 hover:scale-95">
                                                            <i class="fa-solid fa-plus me-1"></i>
                                                            Add Part Reading
                                                        </a>
                                                    </div>

                                                    <div class="">
                                                        <a href="{{ url('/dashPetugasSoalDetailReading' . '/' . $data->id_bank) }}"
                                                            class="flex items-center w-full px-4 py-2 text-yellow-300
                                                    hover:bg-gray-100 hover:scale-95">
                                                            <i class="fa-solid fa-clipboard-question me-1"></i>
                                                            Add Question Reading
                                                        </a>
                                                    </div>
                                                </li>

                                                <h1 class="font-semibold text-md mt-3">Other :</h1>
                                                <li class="lg:flex">
                                                    <div class="">
                                                        <button type="button"
                                                            data-modal-target="UpdateBank{{ $data->id_bank }}"
                                                            data-modal-toggle="UpdateBank{{ $data->id_bank }}"
                                                            class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 hover:scale-95">
                                                            <i class="fa-solid fa-pen-to-square me-1 -mt-0.5"></i>
                                                            Update Bank
                                                        </button>
                                                    </div>

                                                    <div class="">
                                                        <button
                                                            onclick="hapus('baris{{ $loop->iteration }}', '{{ $data->id_bank }}')"
                                                            type="button" data-modal-target="DeleteBank"
                                                            data-modal-toggle="DeleteBank"
                                                            class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-gray-100 hover:scale-95">
                                                            <i class="fa-solid fa-trash me-1"></i>
                                                            Delete Bank Question
                                                        </button>
                                                    </div>
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
                    {{ $bank->links() }}
                </div>
            </div>
        </div>
    </section>
    {{-- end konten --}}


    {{-- Modal Tambah --}}
    <div id="TambahBankSoal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                        Create Bank Question
                    </h3>
                    <button type="button"
                        class="end-2.5 text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors outline-none"
                        data-modal-hide="TambahBankSoal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <form class="space-y-4 modal-form" action="{{ url('/TambahBankSoal') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Code Question</label>
                            <input type="text" name="bank" id="name"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : KD-1A" required />
                        </div>

                        {{-- Mode first --}}
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Mode <span class="text-red-500">*</span></label>
                            <select name="mode" id="tambah-mode" required 
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                <option value="toeic" selected>TOEIC Simulation</option>
                                <option value="self_study">Self Study</option>
                            </select>
                            <p class="text-[10px] text-slate-400 font-semibold mt-1">Choose which feature this bank will be used in.</p>
                        </div>

                        {{-- Session — hidden when Self Study --}}
                        <div id="tambah-session-group">
                            <label for="tambah-sesi" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Session</label>
                            <select id="tambah-sesi" name="sesi_bank"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                <option selected hidden value="">-- Select --</option>
                                <option value="Session 1">Session 1</option>
                                <option value="Session 2">Session 2</option>
                            </select>
                        </div>
                        <input type="hidden" id="tambah-sesi-hidden" name="sesi_bank" value="Self Study" disabled>

                        {{-- Time field — hidden when Self Study --}}
                        <div id="tambah-time-group">
                            <label for="end_time" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">End Time</label>
                            <input type="time" name="waktu_akhir" id="end_time"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none font-medium" />
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md hover:shadow-blue-600/20 active:scale-95 cursor-pointer mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah --}}

    {{-- Modal Update --}}
    @foreach ($bank as $data)
        <div id="UpdateBank{{ $data->id_bank }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full p-4">
                <!-- Modal content -->
                <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                            Update Bank Question
                        </h3>
                        <button type="button"
                            class="end-2.5 text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors outline-none"
                            data-modal-hide="UpdateBank{{ $data->id_bank }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-6">
                        <form class="space-y-4 modal-form" action="{{ url('/UpdateBankSoal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_bank" value="{{ $data->id_bank }}">

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Code Question</label>
                                <input type="text" name="bank" value="{{ $data->bank }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : KD-1A" required />
                            </div>

                            {{-- Mode first --}}
                            <div>
                                <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Mode <span class="text-red-500">*</span></label>
                                <select name="mode" id="update-mode-{{ $data->id_bank }}" required 
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium update-mode-select"
                                    data-bank-id="{{ $data->id_bank }}">
                                    <option value="toeic" {{ $data->mode === 'toeic' ? 'selected' : '' }}>TOEIC Simulation</option>
                                    <option value="self_study" {{ $data->mode === 'self_study' ? 'selected' : '' }}>Self Study</option>
                                </select>
                                <p class="text-[10px] text-slate-400 font-semibold mt-1">Choose which feature this bank will be used in.</p>
                            </div>

                            {{-- Session — hidden when Self Study --}}
                            <div id="update-session-group-{{ $data->id_bank }}" {{ $data->mode === 'self_study' ? 'style=display:none' : '' }}>
                                <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Session</label>
                                <select id="update-sesi-{{ $data->id_bank }}" name="sesi_bank"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    <option selected hidden value="{{ $data->sesi_bank }}">{{ $data->sesi_bank }}</option>
                                    <option value="Session 1">Session 1</option>
                                    <option value="Session 2">Session 2</option>
                                </select>
                            </div>
                            <input type="hidden" id="update-sesi-hidden-{{ $data->id_bank }}" name="sesi_bank" value="Self Study"
                                {{ $data->mode !== 'self_study' ? 'disabled' : '' }}>

                            {{-- Time field — hidden when Self Study --}}
                            <div id="update-time-group-{{ $data->id_bank }}" {{ $data->mode === 'self_study' ? 'style=display:none' : '' }}>
                                <label for="end_time" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">End Time</label>
                                <input type="time" name="waktu_akhir" id="end_time"
                                    value="{{ $data->waktu_akhir }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none font-medium" />
                            </div>

                            <button type="submit"
                                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md hover:shadow-blue-600/20 active:scale-95 cursor-pointer mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal --}}

    {{-- Modal Delete --}}
    <div id="DeleteBank" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="DeleteBank">
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

                <h3 class="mb-2 text-lg font-bold text-gray-900">Delete Bank Question?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to delete this bank question? All associated parts and questions will be permanently deleted. This action cannot be undone.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/DeleteBankSoal') }}" method="POST">
                        @csrf
                        <input type="hidden" id="hapus-bank" name="id_bank">

                        <button data-modal-toggle="DeleteBank" type="button"
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
        function hapus(baris, id) {
            document.getElementById('hapus-bank').value = id;
        }

        /* ── Create modal: Mode → show/hide Session & Time ── */
        (function () {
            const modeSelect   = document.getElementById('tambah-mode');
            const sessionGroup = document.getElementById('tambah-session-group');
            const sesiSelect   = document.getElementById('tambah-sesi');
            const sesiHidden   = document.getElementById('tambah-sesi-hidden');
            const timeGroup    = document.getElementById('tambah-time-group');

            function applyTambahMode(val) {
                const isSelfStudy = val === 'self_study';
                sessionGroup.style.display = isSelfStudy ? 'none' : '';
                timeGroup.style.display    = isSelfStudy ? 'none' : '';
                sesiSelect.disabled        = isSelfStudy;
                sesiHidden.disabled        = !isSelfStudy;
            }

            if (modeSelect) {
                modeSelect.addEventListener('change', () => applyTambahMode(modeSelect.value));
                applyTambahMode(modeSelect.value);
            }
        })();

        /* ── Update modals: Mode → show/hide per bank ID ── */
        document.querySelectorAll('.update-mode-select').forEach(select => {
            const id = select.dataset.bankId;
            const sessionGroup = document.getElementById('update-session-group-' + id);
            const sesiSelect   = document.getElementById('update-sesi-' + id);
            const sesiHidden   = document.getElementById('update-sesi-hidden-' + id);
            const timeGroup    = document.getElementById('update-time-group-' + id);

            function applyUpdateMode(val) {
                const isSelfStudy = val === 'self_study';
                if (sessionGroup) sessionGroup.style.display = isSelfStudy ? 'none' : '';
                if (timeGroup)    timeGroup.style.display    = isSelfStudy ? 'none' : '';
                if (sesiSelect)   sesiSelect.disabled        = isSelfStudy;
                if (sesiHidden)   sesiHidden.disabled        = !isSelfStudy;
            }

            select.addEventListener('change', () => applyUpdateMode(select.value));
            applyUpdateMode(select.value);
        });
    </script>

@endsection
