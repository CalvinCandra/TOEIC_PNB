{{-- menghubungkan file main --}}
@extends('admin.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Admin | Part Question')

@php
    use App\Models\Gambar;
    use App\Models\Audio;
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
        <h1>Part Question Listening</h1>

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
                @include('layouts.dashboard.live-search', ['placeholder' => 'Search parts...'])
                {{-- end search --}}
                @if (isset($hasReading) && $hasReading)
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
                        <span class="font-medium">⚠️ Cannot add new Listening Part</span>
                        <p class="mt-1">This bank already has Reading Part(s). To maintain question number consistency,
                        you cannot add more Listening Parts after Reading exists. Delete all Reading Parts first if needed.</p>
                    </div>
                @elseif (isset($isListeningFull) && $isListeningFull)
                    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 border border-yellow-200">
                        <span class="font-medium">Maximum reached!</span>
                        This bank already has 4 Listening Parts (Part 1-4). You cannot add more.
                    </div>
                @endif
                <div class="flex mt-5 justify-between">
                    <!-- Modal toggle -->
                    <button data-modal-target="TambahPartListening" data-modal-toggle="TambahPartListening"
                        @if((isset($hasReading) && $hasReading) || (isset($isListeningFull) && $isListeningFull)) disabled @endif
                        class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5 {{ ((isset($hasReading) && $hasReading) || (isset($isListeningFull) && $isListeningFull)) ? 'opacity-50 cursor-not-allowed' : '' }}"
                        type="button">
                        Create Part Listening
                    </button>
                </div>
                <div id="search-results-container">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">

                    <div class="overflow-x-auto w-full">

                        <!-- table data -->
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2">No</th>
                                    <th scope="col" class="px-4 py-3 border-2">Part</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[300px]">Derection
                                    </th>
                                    <th scope="col" class="px-4 py-3 border-2">Number Question</th>
                                    <th scope="col" class="px-4 py-3 border-2">Image</th>
                                    <th scope="col" class="px-4 py-3 border-2">Audio</th>
                                    <th scope="col" class="px-4 py-3 border-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($part as $data)
                                    <tr class="border-b" id="baris{{ $loop->iteration }}">
                                        <th class="px-4 py-3 border-2">{{ $loop->iteration }}</th>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->part }}</td>
                                        <td class="px-4 py-3 border-2">{!! $data->petunjuk !!}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{ $data->dari_nomor }} -
                                            {{ $data->sampai_nomor }}</td>

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

                                        @if (!$data->id_audio == null)
                                            <td class="px-4 py-3 border-2">
                                                <audio id="audio" controls>
                                                    <source src="{{ $urlpathaudio . $data->audio->audio }}" type="audio/mp3"
                                                        class="bg-[#023047] text-white">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </td>
                                        @else
                                            <td class="px-4 py-3 border-2 whitespace-nowrap italic text-slate-300">Nothing
                                            </td>
                                        @endif

                                        <td class="px-4 py-3 border-2 whitespace-nowrap">
                                            <ul class="flex py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                <li>
                                                    <button
                                                        onclick="edit('baris{{ $loop->iteration }}', '{{ $data->id_part }}')"
                                                        type="button" data-modal-target="UpdatePart{{ $data->id_part }}"
                                                        data-modal-toggle="UpdatePart{{ $data->id_part }}"
                                                        class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-pen-to-square me-1 -mt-0.5"></i>
                                                        Update Part
                                                    </button>
                                                </li>
                                                <li>
                                                    <button
                                                        onclick="hapus('baris{{ $loop->iteration }}', '{{ $data->id_part }}')"
                                                        type="button" data-modal-target="DeletePart"
                                                        data-modal-toggle="DeletePart"
                                                        class="flex items-center w-full px-4 py-2 text-red-500 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-trash me-1"></i>
                                                        Delete Part
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
                    {{ $part->links() }}
                </div>
                </div> {{-- end search-results-container --}}
            </div>
        </div>
    </section>
    {{-- end konten --}}

    {{-- Modal Tambah --}}
    <div id="TambahPartListening" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Create Part Listening
                    </h3>
                    <button type="button"
                        class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                        data-modal-hide="TambahPartListening">
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
                    <form class="space-y-4 modal-form" action="{{ url('/TambahPartListeningAdmin') }}" method="POST"
                        id="formTambah" enctype="multipart/form-data">
                        @csrf

                        {{-- ambil id_bank --}}
                        <input type="hidden" value="{{ $id_bank }}" name="id_bank">
                        {{-- get tanda --}}
                        <input type="hidden" value="{{ $nomor }}" name="tanda">

                        <div>
                            <label for="part" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Part</label>
                            <input type="text" name="part" id="part"
                                value="{{ $nextPartName ?? 'Part 1' }}"
                                readonly
                                class="bg-gray-100 border border-gray-200 text-slate-400 text-sm rounded-xl block w-full p-3.5 transition-all duration-200 font-medium cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">Part name is auto-generated based on order</p>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Direction</label>
                            <textarea rows="5" name="petunjuk" id="editorTambah"
                                style="visibility: hidden; height: 0; position: absolute; z-index: -1;"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"></textarea>
                            <p id="note" class="text-red-500 italic"></p>
                        </div>

                        <div>
                            <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Number<span
                                    class="text-red-500">*</span></label>
                            <div class="flex">
                                <div class="flex items-center">
                                    <label for="name"
                                        class="mb-2 block text-sm font-semibold text-gray-900">From</label>
                                    <input type="number" name="dari_nomor" min="1" value="{{ $angka }}"
                                        class="mx-2 mb-2 bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        placeholder="Example : 1" required readonly />
                                </div>

                                <div class="flex items-center">
                                    <label for="name"
                                        class="mb-2 block text-sm font-semibold text-gray-900">To</label>
                                    <input type="number" name="sampai_nomor" min="1"
                                        class="mx-2 mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        placeholder="Example : 5" required />
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Select an File
                                Image (Opsional)</label>
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
                                Audio</label>
                            <select id="countries" name="audio"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium"
                                required>
                                <option selected hidden value="">-- Choose a File Audio --</option>
                                @foreach ($audio as $item)
                                    <option value="{{ $item->id_audio }}">{{ $item->audio }}</option>
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

    @foreach ($part as $data)
        {{-- Modal Update --}}
        <div id="UpdatePart{{ $data->id_part }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Update Part Listening
                        </h3>
                        <button type="button"
                            class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                            data-modal-hide="UpdatePart{{ $data->id_part }}">
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
                        <form class="space-y-4 modal-form" action="{{ url('/UpdatePartListeningAdmin') }}"
                            method="POST">
                            @csrf

                            <input type="hidden" value="{{ $data->id_part }}" name="id_part" id="">

                            {{-- ambil id_bank --}}
                            <input type="hidden" value="{{ $id_bank }}" name="id_bank">

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Part</label>
                                <input type="text" value="{{ $data->part }}" name="part" id="name"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none placeholder:text-slate-400 font-medium"
                                    placeholder="Example : Part 1" required />
                            </div>

                            <div>
                                <label class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Direction</label>
                                <textarea rows="5" name="petunjuk" id="editorUpdate{{ $data->id_part }}"
                                    class="editor p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ $data->petunjuk }}</textarea>
                            </div>

                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">Number<span
                                        class="text-red-500">*</span></label>
                                <div class="flex">
                                    <div class="flex items-center">
                                        <label for="name"
                                            class="mb-2 block text-sm font-semibold text-gray-900">From</label>
                                        <input type="number" name="dari_nomor" min="1"
                                            value="{{ $data->dari_nomor }}"
                                            class="mx-2 mb-2 bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Example : 1" required readonly />
                                    </div>

                                    <div class="flex items-center">
                                        <label for="name"
                                            class="mb-2 block text-sm font-semibold text-gray-900">To</label>
                                        <input type="number" name="sampai_nomor" min="1"
                                            value="{{ $data->sampai_nomor }}"
                                            class="mx-2 mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Example : 5" required />
                                    </div>
                                </div>
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
                                        <option value="" class="italic text-red-500">Remove Image From Question
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="">
                                <label for="countries" class="block mb-1.5 text-xs font-bold text-slate-650 uppercase tracking-wider">File
                                    Audio</label>
                                <select id="countries" name="audio"
                                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white block w-full p-3.5 transition-all duration-200 outline-none cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_14px_center] bg-[size:18px_18px] bg-no-repeat pr-10 font-medium">
                                    @php
                                        $Audio = Audio::where('id_audio', $data->id_audio)->first();
                                    @endphp

                                    @if (!$data->id_audio)
                                        <option selected hidden value="">Choose a File Audio</option>
                                        @foreach ($audio as $item)
                                            <option value="{{ $item->id_audio }}">{{ $item->audio }}</option>
                                        @endforeach
                                    @else
                                        <option selected hidden value="{{ $Audio->id_audio }}">{{ $Audio->audio }}
                                        </option>
                                        @foreach ($audio as $item)
                                            <option value="{{ $item->id_audio }}">{{ $item->audio }}</option>
                                        @endforeach
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
    <div id="DeletePart" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="DeletePart">
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

                <h3 class="mb-2 text-lg font-bold text-gray-900">Delete Part?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to delete this part? All questions and media files inside this part will be permanently removed. This action cannot be undone.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/DeletePartListeningAdmin') }}" method="POST">
                        @csrf
                        <input type="hidden" id="hapus-part" name="id_part">

                        <button data-modal-toggle="DeletePart" type="button"
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

            document.getElementById('hapus-part').value = id;
        }
    </script>

@endsection
