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
                <div class="flex-warp lg:flex">
                    <button data-modal-target="TambahPesertaExcel" data-modal-toggle="TambahPesertaExcel" class="lg:mx-2 block text-white bg-sky-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5" type="button">
                        Create With Excel
                    </button>

                    <a href="{{url('/downloadtemplateadmin')}}" class="text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-sm px-5 flex items-center text-center mb-5" target="_blank">
                        Download Template
                    </a>
                </div>
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
                                <th scope="col" class="px-4 py-3 border-2">Session</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Question Work Status</th>
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
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->jurusan}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->sesi}}</td>

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
                {{$peserta->links()}}
            </div>
        </div>
    </div>
</section>
{{-- end konten --}}

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
                <form class="space-y-4 modal-form" action="{{url('/TambahPesertaExcelAdmin')}}" method="POST" enctype="multipart/form-data">
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



@endsection