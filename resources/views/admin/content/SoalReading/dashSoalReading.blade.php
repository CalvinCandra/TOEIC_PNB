{{-- menghubungkan file main --}}
@extends('admin.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Admin | Question')

@php
    use App\Models\Gambar;
@endphp

{{-- membuat content disini --}}
@section('content')

    {{-- konten --}}
    <section class="p-4 md:ml-64 h-auto pt-20">
        <a href="{{ url('/dashAdminSoal') }}"
            class="w-[20%] md:w-[10%] block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
            type="button">
            Back
        </a>
        <h1>Question Reading</h1>


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
                    <button data-modal-target="TambahSoal" data-modal-toggle="TambahSoal"
                        class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
                        type="button">
                        Create Question Reading
                    </button>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="overflow-x-auto w-full">
                        <!-- table data -->
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2 whitespace-nowrap">Nomor</th>
                                    <th scope="row" class="px-4 py-3 border-2 whitespace-nowrap pe-[300px]">Supporting
                                        sentences</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[300px]">Question</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">Option A</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">OPtion B</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">OPtion C</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">OPtion D</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Key</th>
                                    <th scope="col" class="px-4 py-3 border-2">Image 1</th>
                                    <th scope="col" class="px-4 py-3 border-2">Image 2</th>
                                    <th scope="col" class="px-4 py-3 border-2">Image 3</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Staff</th>
                                    <th scope="col" class="px-4 py-3 border-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soal as $data)
                                    <tr class="border-b" id="baris{{ $data->nomor_soal }}">

                                        <td class="px-4 py-3 border-2">{{ $data->nomor_soal }}</td>

                                        @if (!$data->text == null)
                                            <td class="px-4 py-3 border-2 ">{!! $data->text !!}</td>
                                        @else
                                            <td class="px-4 py-3 border-2 italic text-slate-300">Nothing</td>
                                        @endif

                                        @if (!$data->soal == null)
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->soal }}</td>
                                        @else
                                            <td class="px-4 py-3 border-2 italic text-slate-300">Nothing</td>
                                        @endif

                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->jawaban_a }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->jawaban_b }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->jawaban_c }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->jawaban_d }}</td>
                                        <td class="px-4 py-3 border-2">{{ $data->kunci_jawaban }}</td>

                                        @if (!$data->id_gambar == null)
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">
                                                <a class="" href="{{ $urlpathimage . $data->gambar->gambar }}"
                                                    data-lightbox="example-1" target="__blank" id='link-foto'>
                                                    <h1 class="text-sky-500 italic font-weight-bold hover:underline">See
                                                        Image</h1>
                                                </a>
                                            </td>
                                        @else
                                            <td class="px-4 py-3 border-2 whitespace-nowrap italic text-slate-300">Nothing
                                            </td>
                                        @endif

                                        @if (!$data->id_gambar_1 == null)
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">
                                                <a class="" href="{{ $urlpathimage . $data->gambar1->gambar }}"
                                                    data-lightbox="example-1" target="__blank" id='link-foto'>
                                                    <h1 class="text-sky-500 italic font-weight-bold hover:underline">See
                                                        Image</h1>
                                                </a>
                                            </td>
                                        @else
                                            <td class="px-4 py-3 border-2 whitespace-nowrap italic text-slate-300">Nothing
                                            </td>
                                        @endif

                                        @if (!$data->id_gambar_2 == null)
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">
                                                <a class="" href="{{ $urlpathimage . $data->gambar2->gambar }}"
                                                    data-lightbox="example-1" target="__blank" id='link-foto'>
                                                    <h1 class="text-sky-500 italic font-weight-bold hover:underline">See
                                                        Image</h1>
                                                </a>
                                            </td>
                                        @else
                                            <td class="px-4 py-3 border-2 whitespace-nowrap italic text-slate-300">Nothing
                                            </td>
                                        @endif

                                        @if (!$data->id_users == null)
                                            <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->user->name }}</td>
                                        @else
                                            <td class="px-4 py-3 border-2 whitespace-nowrap italic text-slate-300">Nothing
                                            </td>
                                        @endif

                                        <td class="px-4 py-3 border-2">
                                            <ul class="flex py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                <li>
                                                    <button type="button"
                                                        data-modal-target="UpdateSoal{{ $data->id_soal }}"
                                                        data-modal-toggle="UpdateSoal{{ $data->id_soal }}"
                                                        class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-pen-to-square me-1 -mt-0.5"></i>
                                                        Update
                                                    </button>
                                                </li>
                                                <li>
                                                    <button
                                                        onclick="hapus('baris{{ $data->nomor_soal }}', '{{ $data->id_soal }}')"
                                                        type="button" data-modal-target="DeleteSoal"
                                                        data-modal-toggle="DeleteSoal"
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
                    {{ $soal->links() }}
                </div>
            </div>
        </div>
    </section>
    {{-- end konten --}}


    {{-- Modal Tambah --}}
    <div id="TambahSoal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Create Question Reading
                    </h3>
                    <button type="button"
                        class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                        data-modal-hide="TambahSoal">
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
                    <form class="space-y-4 modal-form" action="{{ url('/TambahSoalReadingAdmin') }}" method="POST">
                        @csrf
                        {{-- ambil id_bank --}}
                        <input type="hidden" value="{{ $id_bank }}" name="id_bank">

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Number
                                Question<span class="text-red-500">*</span></label>
                            <input type="number" name="nomor_soal"
                                class="bg-gray-100 border border-gray-200 text-slate-400 text-sm rounded-xl block w-full p-3.5 transition-all duration-200 font-medium cursor-not-allowed"
                                value="{{ $nomor }}" readonly />
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Supporting sentences
                                (Opsional)</label>
                            <p class="text-xs italic text-slate-400 mt-2.5 mb-3 block font-medium"><span class="font-bold text-slate-500">Note:</span> If
                                there
                                are Supporting sentences, please fill in this form, otherwise please leave it blank.</p>
                            <textarea rows="5" name="text" id="editorTambah"
                                style="visibility: hidden; height: 0; position: absolute; z-index: -1;"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"></textarea>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Question</label>
                            <p class="text-xs italic text-slate-400 mt-2.5 mb-3 block font-medium"><span class="font-bold text-slate-500">Note:</span> If
                                there
                                are Question, please fill in this form, otherwise please leave it blank.</p>
                            <textarea id="message" name="soal" rows="4"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Write question here"></textarea>
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option A<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="jawaban_a"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : This is answer a" required />
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option B<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="jawaban_b"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : This is answer b" required />
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option C<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="jawaban_c"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : This is answer c" required />
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option D<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="jawaban_d"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                placeholder="Example : This is answer d" required />
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Key<span
                                    class="text-red-500">*</span></label>
                            <select id="countries" name="kunci_jawaban"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium"
                                required>
                                <option selected hidden value="">Choose a Key</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <div class="">
                            <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Select an File
                                Image 1 (Opsional)</label>
                            <select id="countries" name="gambar"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                <option selected hidden value="">-- Choose a File Image --</option>
                                @foreach ($gambar as $item)
                                    <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="">
                            <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Select an File
                                Image 2 (Opsional)</label>
                            <select id="countries" name="gambar1"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                <option selected hidden value="">-- Choose a File Image --</option>
                                @foreach ($gambar as $item)
                                    <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="">
                            <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Select an File
                                Image 3 (Opsional)</label>
                            <select id="countries" name="gambar2"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                <option selected hidden value="">-- Choose a File Image --</option>
                                @foreach ($gambar as $item)
                                    <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md hover:shadow-blue-600/20 active:scale-95 cursor-pointer mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah --}}

    @foreach ($soal as $data)
        {{-- Modal Update --}}
        <div id="UpdateSoal{{ $data->id_soal }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Update Question Data
                        </h3>
                        <button type="button"
                            class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                            data-modal-hide="UpdateSoal{{ $data->id_soal }}">
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
                        <form class="space-y-4 modal-form" action="{{ url('/UpdateSoalReadingAdmin') }}" method="POST">
                            @csrf

                            <input type="hidden" name="id_soal" value="{{ $data->id_soal }}">

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Number
                                    Question<span class="text-red-500">*</span></label>
                                <input type="number" name="nomor_soal"
                                    class="bg-gray-100 border border-gray-200 text-slate-400 text-sm rounded-xl block w-full p-3.5 transition-all duration-200 font-medium cursor-not-allowed"
                                    value="{{ $data->nomor_soal }}" readonly />
                            </div>

                            <div>
                                <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Supporting sentences
                                    (Opsional)</label>
                                <p class="text-xs italic text-slate-400 mt-2.5 mb-3 block font-medium"><span class="font-bold text-slate-500">Note:</span> If
                                    there
                                    are Supporting sentences, please fill in this form, otherwise please leave it blank.</p>
                                <textarea rows="5" name="text" id="editorUpdate{{ $data->id_soal }}"
                                    class="editor p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ $data->text }}</textarea>
                            </div>

                            <div>
                                <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Question</label>
                                <p class="text-xs italic text-slate-400 mt-2.5 mb-3 block font-medium"><span class="font-bold text-slate-500">Note:</span> If
                                    there
                                    are Question, please fill in this form, otherwise please leave it blank.</p>
                                <textarea id="message" name="soal" rows="4"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Write question here">{{ $data->soal }}</textarea>
                            </div>

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option A<span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="jawaban_a" value="{{ $data->jawaban_a }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : This is answer a" required />
                            </div>

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option B<span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="jawaban_b" value="{{ $data->jawaban_b }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : This is answer b" required />
                            </div>

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option C<span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="jawaban_c" value="{{ $data->jawaban_c }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : This is answer c" required />
                            </div>

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Option D<span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="jawaban_d" value="{{ $data->jawaban_d }}"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : This is answer d" required />
                            </div>

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Key<span
                                        class="text-red-500">*</span></label>
                                <select id="countries" name="kunci_jawaban"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium"
                                    required>
                                    <option selected hidden value="{{ $data->kunci_jawaban }}">{{ $data->kunci_jawaban }}
                                    </option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>

                            <div class="">
                                <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">File
                                    Image</label>
                                <select id="countries" name="gambar"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    @php
                                        $Gambar = Gambar::where('id_gambar', $data->id_gambar)->first();
                                    @endphp

                                    @if (!$data->id_gambar)
                                        <option selected hidden value="">-- Choose a File Image --</option>
                                        @foreach ($gambar as $item)
                                            <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                        @endforeach
                                    @else
                                        <option selected hidden value="{{ $Gambar->id_gambar }}">{{ $Gambar->gambar }}
                                        </option>
                                        @foreach ($gambar as $item)
                                            <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                        @endforeach
                                        <option value="" class="text-red-500 italic">Remove Image From Question
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="">
                                <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">File
                                    Image</label>
                                <select id="countries" name="gambar1"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    @php
                                        $Gambar = Gambar::where('id_gambar', $data->id_gambar_1)->first();
                                    @endphp

                                    @if (!$data->id_gambar_1)
                                        <option selected hidden value="">-- Choose a File Image --</option>
                                        @foreach ($gambar as $item)
                                            <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                        @endforeach
                                    @else
                                        <option selected hidden value="{{ $Gambar->id_gambar }}">{{ $Gambar->gambar }}
                                        </option>
                                        @foreach ($gambar as $item)
                                            <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                        @endforeach
                                        <option value="" class="text-red-500 italic">Remove Image From Question
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="">
                                <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">File
                                    Image</label>
                                <select id="countries" name="gambar2"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    @php
                                        $Gambar = Gambar::where('id_gambar', $data->id_gambar_2)->first();
                                    @endphp

                                    @if (!$data->id_gambar_2)
                                        <option selected hidden value="">-- Choose a File Image --</option>
                                        @foreach ($gambar as $item)
                                            <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                        @endforeach
                                    @else
                                        <option selected hidden value="{{ $Gambar->id_gambar }}">{{ $Gambar->gambar }}
                                        </option>
                                        @foreach ($gambar as $item)
                                            <option value="{{ $item->id_gambar }}">{{ $item->gambar }}</option>
                                        @endforeach
                                        <option value="" class="text-red-500 italic">Remove Image From Question
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md hover:shadow-blue-600/20 active:scale-95 cursor-pointer mt-2">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal --}}
    @endforeach

    {{-- Modal Delete --}}
    <div id="DeleteSoal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="DeleteSoal">
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

                <h3 class="mb-2 text-lg font-bold text-gray-900">Delete Question?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to delete this question? This action cannot be undone and all associated data will be permanently removed.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/DeleteSoalReadingAdmin') }}" method="POST">
                        @csrf
                        <input type="hidden" id="hapus-soal" name="id_soal">

                        <button data-modal-toggle="DeleteSoal" type="button"
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
            const td = document.querySelectorAll('#' + baris + ' td');

            document.getElementById('hapus-soal').value = id;
        }
    </script>

@endsection
