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
                    class="block text-white bg-sky-800 hover:bg-blue-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5"
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
                                <th scope="col" class="px-4 py-3 border-2">Start Time</th>
                                <th scope="col" class="px-4 py-3 border-2">End Time</th>
                                <th scope="col" class="px-4 py-3 border-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bank as $data)
                            <tr class="border-b" id="baris{{$loop->iteration}}">
                                <th class="px-4 py-3 border-2">{{$loop->iteration}}</th>
                                <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->bank}}</td>
                                <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->sesi_bank}}</td>
                                <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->waktu_mulai}}</td>
                                <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->waktu_akhir}}</td>
                                <td class="px-4 py-3 border-2 whitespace-nowrap">
                                    <ul class="lg:block py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">

                                        <h1 class="font-semibold text-md">For Listening :</h1>
                                        <li class="lg:flex">
                                            <div class="">
                                                <a href="{{url("/dashPetugasPartListening"."/".$data->id_bank)}}"
                                                    class="flex items-center w-full px-4 py-2 text-purple-700
                                                    hover:bg-gray-100 hover:scale-95">
                                                    <i class="fa-solid fa-plus me-1"></i>
                                                    Add Part Listening
                                                </a>
                                            </div>

                                            <div class="">
                                                <a href="{{url("/dashPetugasSoalDetailListening"."/".$data->id_bank)}}"
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
                                                <a href="{{url("/dashPetugasPartReading"."/".$data->id_bank)}}"
                                                    class="flex items-center w-full px-4 py-2 text-yellow-300
                                                    hover:bg-gray-100 hover:scale-95">
                                                    <i class="fa-solid fa-plus me-1"></i>
                                                    Add Part Reading
                                                </a>
                                            </div>

                                            <div class="">
                                                <a href="{{url("/dashPetugasSoalDetailReading"."/".$data->id_bank)}}"
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
                                                <button type="button" data-modal-target="UpdateBank{{$data->id_bank}}"
                                                    data-modal-toggle="UpdateBank{{$data->id_bank}}"
                                                    class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 hover:scale-95">
                                                    <i class="fa-solid fa-pen-to-square me-1 -mt-0.5"></i>
                                                    Update Bank
                                                </button>
                                            </div>

                                            <div class="">
                                                <button
                                                    onclick="hapus('baris{{$loop->iteration}}', '{{$data->id_bank}}')"
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
                {{$bank->links()}}
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
        <div class="relative bg-white rounded-lg shadow">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Create Bank Question
                </h3>
                <button type="button"
                    class="end-2.5 text-sky-950 bg-transparent hover:bg-sky-950 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
            <div class="p-4 md:p-5">
                <form class="space-y-4 modal-form" action="{{url('/TambahBankSoal')}}" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Code Question</label>
                        <input type="text" name="bank" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : KD-1A" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Session</label>
                        <select id="countries" name="sesi_bank"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            required>
                            <option selected hidden value="">-- Select --</option>
                            <option value="Session 1">Session 1</option>
                            <option value="Session 2">Session 2</option>
                            <option value="Session 3">Session 3</option>
                            <option value="Session 4">Session 4</option>
                            <option value="Session 5">Session 5</option>
                            <option value="Session 6">Session 6</option>
                            <option value="Session 7">Session 7</option>
                            <option value="Session 8">Session 8</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">Start Time</label>
                        <input type="time" name="waktu_mulai" id="start_time"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required />
                    </div>

                    <div>
                        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">End Time</label>
                        <input type="time" name="waktu_akhir" id="end_time"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required />
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-sky-800 hover:bg-sky-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Tambah --}}

{{-- Modal Update --}}
@foreach ($bank as $data)
<div id="UpdateBank{{$data->id_bank}}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Update Bank Question
                </h3>
                <button type="button"
                    class="end-2.5 text-sky-950 bg-transparent hover:bg-sky-950 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="UpdateBank{{$data->id_bank}}">
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
                <form class="space-y-4 modal-form" action="{{url('/UpdateBankSoal')}}" method="POST">
                    @csrf

                    <input type="hidden" name="id_bank" value="{{$data->id_bank}}">

                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Code Question</label>
                        <input type="text" name="bank" value="{{$data->bank}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : KD-1A" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Session</label>
                        <select id="countries" name="sesi_bank"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option selected hidden value="{{ $data->sesi_bank }}">{{$data->sesi_bank}}</option>
                            <option value="Session 1">Session 1</option>
                            <option value="Session 2">Session 2</option>
                            <option value="Session 3">Session 3</option>
                            <option value="Session 4">Session 4</option>
                            <option value="Session 5">Session 5</option>
                            <option value="Session 6">Session 6</option>
                            <option value="Session 7">Session 7</option>
                            <option value="Session 8">Session 8</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">Start Time</label>
                        <input type="time" name="waktu_mulai" id="start_time" value="{{ $data->waktu_mulai }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required />
                    </div>

                    <div>
                        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">End Time</label>
                        <input type="time" name="waktu_akhir" id="end_time" value="{{ $data->waktu_akhir }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required />
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-sky-800 hover:bg-sky-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>

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
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow ">

            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                data-modal-toggle="DeleteBank">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <i class="fa-solid fa-trash text-gray-300 text-3xl mx-auto my-3"></i>

            <p class="mb-4 text-gray-500 dark:text-gray-300">Are You Sure Delete?</p>
            <div class="flex justify-center items-center space-x-4">
                <form class="modal-form" action="{{url('/DeleteBankSoal')}}" method="POST">
                    @csrf
                    <input type="hidden" id="hapus-bank" name="id_bank">

                    <button data-modal-toggle="DeleteBank" type="button"
                        class="py-2 px-3 text-sm font-medium text-gray-500 bg-gray-200 rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                        Cancel</button>
                    <input type="submit"
                        class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900"
                        value="Yes, I'm Sure!">
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}



<script>
    function hapus(baris, id) {
        const td = document.querySelectorAll('#' + baris + ' td');

        document.getElementById('hapus-bank').value = id;
    }
</script>

@endsection