{{-- menghubungkan file main --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Staff | Participants')

{{-- membuat content disini --}}
@section('content')

{{-- konten --}}
<section class="p-4 md:ml-64 h-auto pt-20">
    <h1>Participants Data</h1>

    <div class="p-3 sm:p-5 antialiased">
        @if (count($errors) > 0)
            <div id="alert-2" class="flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="ml-3 text-sm font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('gagal'))
            <div id="alert-2" class="flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
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
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
            <div class="block lg:flex justify-between mt-5 ">
                <!-- Modal toggle -->
                <div class="block lg:flex">
                    <button data-modal-target="TambahPeserta" data-modal-toggle="TambahPeserta" class="block text-white bg-sky-800 hover:bg-blue-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5" type="button">
                        Create Participants Data
                    </button>

                    <button data-modal-target="TambahPesertaExcel" data-modal-toggle="TambahPesertaExcel" class="lg:mx-2 block text-white bg-sky-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5" type="button">
                        Create With Excel
                    </button>
                </div>

                {{-- action --}}
                <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="flex items-center text-black border-2 border-black font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5" type="button">Action 
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                    
                
                {{-- <a href="{{url('/SendMailPesertaAll')}}" class="block text-white bg-green-400 hover:bg-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5 w-32" type="button">
                    Send Email
                </a> --}}
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
                                <th scope="col" class="px-4 py-3 border-2">Gender</th>
                                <th scope="col" class="px-4 py-3 border-2">Major</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Question Work Status</th>
                                <th scope="col" class="px-4 py-3 border-2">Score Listening</th>
                                <th scope="col" class="px-4 py-3 border-2">Score Reading</th>
                                <th scope="col" class="px-4 py-3 border-2">Total Score</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peserta as $data)
                                <tr class="border-b"
                                id="baris{{$loop->iteration}}">
                                    <th class="px-4 py-3 border-2">{{$loop->iteration}}</th>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->nama_peserta}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->user->email}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->nim}}</td>
                                    @if ($data->kelamin == 'L')
                                        <td class="px-4 py-3 border-2">Male</td>
                                    @else
                                        <td class="px-4 py-3 border-2">Female</td>
                                    @endif
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->jurusan}}</td>

                                    @if ($data->status->status_pengerjaan == 'Sudah')
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">Done</td>
                                    @else
                                        <td class="px-4 py-3 border-2">Yet</td>
                                    @endif

                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->skor_listening}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->skor_reading}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->skor_listening + $data->skor_reading}}</td>

                                    <td class="px-4 py-3 border-2 whitespace-nowrap">
                                        <ul class="flex py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                            <li>
                                                <a href="{{url('/SendMail/Peserta/'.$data->id_peserta)}}"
                                                    class="flex items-center w-full px-4 py-2 text-green-400 hover:bg-gray-100 hover:scale-95">
                                                    <i class="fa-solid fa-paper-plane me-1"></i>
                                                    Send Mail
                                                </a>
                                            </li>
                                            <li>
                                                <button
                                                    type="button" data-modal-target="UpdatePeserta{{$data->id_peserta}}"
                                                    data-modal-toggle="UpdatePeserta{{$data->id_peserta}}"
                                                    class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 hover:scale-95">
                                                    <i class="fa-solid fa-pen-to-square me-1 -mt-0.5"></i>
                                                    Update
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    onclick="hapus('baris{{$loop->iteration}}', '{{$data->id_peserta}}')"
                                                    type="button" data-modal-target="DeletePeserta"
                                                    data-modal-toggle="DeletePeserta"
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
                {{$peserta->links()}}
            </div>
        </div>
    </div>
</section>
{{-- end konten --}}

<!-- Dropdown button menu -->
<div id="dropdownHover" class="relative z-20 hidden bg-white divide-y divide-gray-100 rounded-lg border-2 border-gray-300 w-44">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
    <li>
        <a href="{{url('/SendMailPesertaAll')}}" class="block px-4 py-2 hover:bg-gray-100 text-green-300">Send Email</a>
    </li>
    <li>
        <a href="{{url('/ExportExcelPetugas')}}" target="_blank" class="block px-4 py-2 hover:bg-gray-100 text-sky-600">Export Data (Excel)</a>
    </li>
    <li>
        <button type="button" data-modal-target="ResetStatus" data-modal-toggle="ResetStatus" class="text-left w-full block px-4 py-2 hover:bg-gray-100 text-red-400">Reset Status Work</a>
    </li>
    <li>
        <button type="button" data-modal-target="DeleteAll" data-modal-toggle="DeleteAll" class="text-left w-full block px-4 py-2 hover:bg-gray-100 text-red-600">Delete All Data</button>
    </li>
    </ul>
</div>

{{-- Modal Tambah Excel --}}
<div id="TambahPesertaExcel" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Create Participants Data
                </h3>
                <button type="button"
                    class="end-2.5 text-sky-950 bg-transparent hover:bg-sky-950 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                <form class="space-y-4 modal-form" action="{{url('/TambahPesertaExcelPetugas')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">File Excel</label>
                        <input accept="" name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" required>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-sky-800 hover:bg-sky-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Tambah Excel --}}


{{-- Modal Tambah --}}
<div id="TambahPeserta" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Create Participants Data
                </h3>
                <button type="button"
                    class="end-2.5 text-sky-950 bg-transparent hover:bg-sky-950 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="TambahPeserta">
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
                <form class="space-y-4 modal-form" action="{{url('/TambahPetugasPeserta')}}" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name Full</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : Sopo Jarwo" required />
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : youremail@gmail.com" required />
                    </div>

                    <div>
                        <label for="nim" class="block mb-2 text-sm font-medium text-gray-900">NIM</label>
                        <input type="number" name="nim" id="nim"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : 221535000" required />
                    </div>

                    <div>
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Participant Major</label>
                        <select id="countries" name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option selected hidden value="">Choose a Major</option>
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
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Participant Gender</label>
                        <div class="flex items-center mb-4">
                            <input type="radio" value="L" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                            <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                        </div>
                        <div class="flex items-center">
                            <input id="default-radio-2" type="radio" value="P" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                            <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-sky-800 hover:bg-sky-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Tambah --}}

@foreach ($peserta as $data)    
{{-- Modal Update --}}
<div id="UpdatePeserta{{$data->id_peserta}}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Update Participants Data
                </h3>
                <button type="button"
                    class="end-2.5 text-sky-950 bg-transparent hover:bg-sky-950 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="UpdatePeserta{{$data->id_peserta}}">
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
                <form class="space-y-4 modal-form" action="{{url('/UpdatePetugasPeserta')}}" method="POST">
                    @csrf

                    <input type="hidden" name="id_peserta" value="{{$data->id_peserta}}">

                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name Full</label>
                        <input type="text" name="name" value="{{$data->nama_peserta}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : Sopo Jarwo" required />
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" value="{{$data->user->email}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : youremail@gmail.com" required />
                    </div>

                    <div>
                        <label for="nim" class="block mb-2 text-sm font-medium text-gray-900">NIM</label>
                        <input type="number" name="nim" value="{{$data->nim}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : 221535000" required />
                    </div>

                    <div>
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Participant Major</label>
                        <select id="countries" name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="{{$data->jurusan}}" selected hidden>{{$data->jurusan}}</option>
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
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Question Work Status</label>
                        <select id="countries" name="status_pengerjaan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            @if ($data->status->status_pengerjaan == 'Sudah')
                                <option selected hidden value="{{ $data->status->status_pengerjaan }}">Done</option>
                            @else
                                <option selected hidden value="{{ $data->status->status_pengerjaan }}">Yet</option>
                            @endif
                            <option value="Sudah">Done</option>
                            <option value="Belum">Yet</option>
                        </select>
                    </div>

                    <div>
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Participant Gender</label>
                        @if ($data->kelamin == 'L')
                            <div class="flex items-center mb-4">
                                <input checked type="radio" value="L" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" value="P" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                            </div>
                        @else
                            <div class="flex items-center mb-4">
                                <input type="radio" value="L" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                            </div>
                            <div class="flex items-center">
                                <input checked type="radio" value="P" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                            </div>
                        @endif
                        
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
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow ">

            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                data-modal-toggle="DeletePeserta">
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
                <form class="modal-form" action="{{url('/DeletePetugasPeserta')}}" method="POST">
                    @csrf
                    <input type="hidden" id="hapus-peserta" name="id_peserta">
                    
                    <button data-modal-toggle="DeletePeserta" type="button"
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

{{-- Modal Reset Status--}}
<div id="ResetStatus" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow ">

            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                data-modal-toggle="ResetStatus">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <i class="fa-solid fa-trash text-gray-300 text-3xl mx-auto my-3"></i>

            <p class="mb-4 text-gray-500 dark:text-gray-300">Are You Sure Reset All Status?</p>
            <div class="flex justify-center items-center space-x-4">
                <form class="modal-form" action="{{url('/ResetStatusPetugas')}}" method="POST">
                    @csrf
                    
                    <button data-modal-toggle="ResetStatus" type="button"
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

{{-- End Modal Delete All --}}
{{-- Modal Delete All --}}
<div id="DeleteAll" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow ">

            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                data-modal-toggle="DeleteAll">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <i class="fa-solid fa-trash text-gray-300 text-3xl mx-auto my-3"></i>

            <p class="mb-4 text-gray-500 dark:text-gray-300">Are You Sure Delete All?</p>
            <div class="flex justify-center items-center space-x-4">
                <form class="modal-form" action="{{url('/DeleteAllPetugas')}}" method="POST">
                    @csrf
                    
                    <button data-modal-toggle="DeleteAll" type="button"
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
{{-- End Modal Delete All --}}





<script>
    function hapus(baris, id) {
        const td = document.querySelectorAll('#' + baris + ' td');

        document.getElementById('hapus-peserta').value = id;
    }

</script>

@endsection