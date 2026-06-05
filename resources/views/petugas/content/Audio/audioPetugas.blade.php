{{-- menghubungkan file main --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Staff | Audio Question')

{{-- membuat content disini --}}
@section('content')

    {{-- konten --}}
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Audio Question</h1>


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
                                value="{{ request('search') }}" placeholder="Search" autocomplete="off">
                        </div>
                    </form>
                </div>
                {{-- end search --}}

                <div class="flex justify-between mt-5">
                    <!-- Modal toggle -->
                    <button data-modal-target="TambahAudio" data-modal-toggle="TambahAudio"
                        class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
                        type="button">
                        Add File Audio
                    </button>
                </div>

                <p class="text-xs italic text-slate-400 mt-2.5 mb-3 block font-medium">
                    <span class="font-bold text-slate-500">Note:</span> Please rename the file name and please remember the file name.
                </p>

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="overflow-x-auto w-full">
                        <!-- table data -->
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2 whitespace-nowrap">No</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Name File Audio</th>
                                    <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Preview</th>
                                    <th scope="col" class="px-4 py-3 border-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($audio as $data)
                                    <tr class="border-b" id="baris{{ $loop->iteration }}">

                                        <td class="px-4 py-3 border-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border-2">{{ $data->audio }}</td>
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">
                                            <audio id="audio" controls>
                                                <source src="{{ $urlpathaudio . $data->audio }}" type="audio/mp3"
                                                    class="bg-[#023047] text-white">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </td>
                                        <td class="px-4 py-3 border-2">
                                            <ul class="flex py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                                <li>
                                                    <button
                                                        onclick="hapus('baris{{ $loop->iteration }}', '{{ $data->id_audio }}')"
                                                        type="button" data-modal-target="DeleteAudio"
                                                        data-modal-toggle="DeleteAudio"
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
                    {{ $audio->links() }}
                </div>
            </div>
        </div>
    </section>
    {{-- end konten --}}


    {{-- Modal Tambah --}}
    <div id="TambahAudio" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-100 rounded-t-3xl bg-slate-50/50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Add File Audio
                    </h3>
                    <button type="button"
                        class="text-slate-400 hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer absolute top-3.5 right-3.5"
                        data-modal-hide="TambahAudio">
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
                    <form class="space-y-4 modal-form" action="{{ url('/TambahAudioPetugas') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file_input">Upload Audio</label>
                            <input accept="audio/mp3, audio/wav" name="audio"
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
    {{-- End Modal Tambah --}}

    {{-- Modal Delete --}}
    <div id="DeleteAudio" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-sm max-h-full">
            <!-- Modal content -->
            <div class="relative p-6 text-center bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

                <button type="button"
                    class="text-slate-400 absolute top-3.5 right-3.5 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-full w-8 h-8 inline-flex items-center justify-center transition-colors outline-none cursor-pointer"
                    data-modal-toggle="DeleteAudio">
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

                <h3 class="mb-2 text-lg font-bold text-gray-900">Delete Audio?</h3>
                <p class="mb-6 text-sm text-gray-500 leading-relaxed">Are you sure you want to delete this audio file? Any listening question using this audio will not function correctly. This action cannot be undone.</p>

                <div class="flex justify-center gap-3">
                    <form class="modal-form w-full flex gap-3" action="{{ url('/DeleteAudioPetugas') }}" method="POST">
                        @csrf
                        <input type="hidden" id="hapus-audio" name="id_audio">

                        <button data-modal-toggle="DeleteAudio" type="button"
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

            document.getElementById('hapus-audio').value = id;
        }
    </script>

@endsection
