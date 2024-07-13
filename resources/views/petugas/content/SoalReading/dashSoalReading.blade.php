{{-- menghubungkan file main --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Staff | Question')

@php
    use App\Models\Gambar;
@endphp

{{-- membuat content disini --}}
@section('content')

{{-- konten --}}
<section class="p-4 md:ml-64 h-auto pt-20">
    <a href="{{url("/dashPetugasSoal")}}" class="w-[20%] md:w-[10%] block text-white bg-sky-800 hover:bg-blue-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5" type="button">
        Back
    </a>
    <h1>Question Reading Data</h1>


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
            <div class="flex justify-between mt-5">
                <!-- Modal toggle -->
                <button data-modal-target="TambahSoal" data-modal-toggle="TambahSoal" class="block text-white bg-sky-800 hover:bg-blue-950 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-5" type="button">
                    Create Question
                </button>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">

                <div class="overflow-x-auto w-full">

                    <!-- table data -->
                    <table class="w-full text-sm text-left text-gray-500 table-auto">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-4 border-2 whitespace-nowrap">Nomor</th>
                                <th scope="row" class="px-4 py-3 border-2 whitespace-nowrap pe-[300px]">Supporting sentences</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[300px]">Question</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">Option A</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">OPtion B</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">OPtion C</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap pe-[150px]">OPtion D</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Key</th>
                                <th scope="col" class="px-4 py-3 border-2">Image</th>
                                <th scope="col" class="px-4 py-3 border-2 whitespace-nowrap">Staff</th>
                                <th scope="col" class="px-4 py-3 border-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soal as $data)
                                <tr class="border-b" id="baris{{$data->nomor_soal}}">

                                    <td class="px-4 py-3 border-2">{{$data->nomor_soal}}</td>

                                    @if (!$data->text == null)
                                        <td class="px-4 py-3 border-2">{{$data->text}}</td>
                                    @else 
                                        <td class="px-4 py-3 border-2 italic text-slate-300">Nothing</td>
                                    @endif

                                    @if (!$data->soal == null)
                                        <td class="px-4 py-3 border-2">{{$data->soal}}</td>
                                    @else 
                                        <td class="px-4 py-3 border-2 italic text-slate-300">Nothing</td>
                                    @endif

                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->jawaban_a}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->jawaban_b}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->jawaban_c}}</td>
                                    <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->jawaban_d}}</td>
                                    <td class="px-4 py-3 border-2">{{$data->kunci_jawaban}}</td>

                                    @if (!$data->id_gambar == null)
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">
                                            <a class="" href="{{ asset('storage/gambar/'.$data->gambar->gambar) }}" data-lightbox="example-1" target="__blank" id='link-foto'>
                                                <h1 class="text-sky-500 italic font-weight-bold hover:underline">See Image</h1>
                                            </a>
                                        </td>
                                    @else 
                                        <td class="px-4 py-3 border-2 whitespace-nowrap italic text-slate-300">Nothing</td>
                                    @endif

                                    @if (!$data->id_users == null)
                                        <td class="px-4 py-3 border-2 whitespace-nowrap">{{$data->user->name}}</td>
                                    @else 
                                        <td class="px-4 py-3 border-2 whitespace-nowrap italic text-slate-300">Nothing</td>
                                    @endif
                                    
                                    <td class="px-4 py-3 border-2">
                                        <ul class="flex py-1 text-sm" aria-labelledby="apple-imac-27-dropdown-button">
                                            <li>
                                                <button
                                                    type="button" data-modal-target="UpdateSoal{{$data->id_soal}}"
                                                    data-modal-toggle="UpdateSoal{{$data->id_soal}}"
                                                    class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 hover:scale-95">
                                                    <i class="fa-solid fa-pen-to-square me-1 -mt-0.5"></i>
                                                    Update
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    onclick="hapus('baris{{$data->nomor_soal}}', '{{$data->id_soal}}')"
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
                {{$soal->links()}}
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
        <div class="relative bg-white rounded-lg shadow">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Create Bank Question Data
                </h3>
                <button type="button"
                    class="end-2.5 text-sky-950 bg-transparent hover:bg-sky-950 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                <form class="space-y-4 modal-form" action="{{url('/TambahSoalReadingPetugas')}}" method="POST">
                    @csrf
                    {{-- ambil id_bank --}}
                    <input type="hidden" value="{{$id_bank}}" name="id_bank">

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Number Question<span class="text-red-500">*</span></label>
                        <input type="number" name="nomor_soal"
                            class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            value="{{$nomor}}" readonly />
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">Supporting sentences</label>
                        <textarea rows="5" name="text" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Supporting sentences"></textarea>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">Question</label>
                        <textarea id="message" name="soal" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write question here"></textarea>
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option A<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_a"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer a" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option B<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_b"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer b" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option C<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_c"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer c" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option D<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_d"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer d" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Key<span class="text-red-500">*</span></label>
                        <select id="countries" name="kunci_jawaban" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option selected hidden value="">-- Choose a Key --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>

                    <div class="">
                        <label for="countries" class="block mb-2 text-sm font-semibold text-gray-900">Select an File Image (Opsional)</label>
                        <select id="countries" name="gambar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option selected hidden value="">-- Choose a File Image --</option>
                            @foreach ($gambar as $item)
                                <option value="{{$item->id_gambar}}">{{$item->gambar}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit"
                        class="w-full text-white bg-sky-800 hover:bg-sky-950 font-semibold rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Tambah --}}

@foreach ($soal as $data)    
{{-- Modal Update --}}
<div id="UpdateSoal{{$data->id_soal}}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 ">
                <h3 class="text-xl font-semibold text-gray-900">
                    Update Participants Data
                </h3>
                <button type="button"
                    class="end-2.5 text-sky-950 bg-transparent hover:bg-sky-950 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="UpdateSoal{{$data->id_soal}}">
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
                <form class="space-y-4 modal-form" action="{{url('/UpdateSoalReadingPetugas')}}" method="POST">
                    @csrf

                    <input type="hidden" name="id_soal" value="{{$data->id_soal}}">

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Number Question<span class="text-red-500">*</span></label>
                        <input type="number" name="nomor_soal"
                            class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            value="{{$data->nomor_soal}}" readonly />
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">Supporting sentences</label>
                        <textarea rows="5" name="text" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="You can leave it blank">{{$data->text}}</textarea>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">Question<span class="text-red-500">*</span></label>
                        <textarea id="message" name="soal" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write question here" required>{{$data->soal}}</textarea>
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option A<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_a" value="{{$data->jawaban_a}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer a" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option B<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_b" value="{{$data->jawaban_b}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer b" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option C<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_c" value="{{$data->jawaban_c}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer c" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Option D<span class="text-red-500">*</span></label>
                        <input type="text" name="jawaban_d" value="{{$data->jawaban_d}}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Example : This is answer d" required />
                    </div>

                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Key<span class="text-red-500">*</span></label>
                        <select id="countries" name="kunci_jawaban" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option selected hidden value="{{$data->kunci_jawaban}}">{{$data->kunci_jawaban}}</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>

                    <div class="">
                        <label for="countries" class="block mb-2 text-sm font-semibold text-gray-900">File Image</label>
                        <select id="countries" name="gambar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            @php
                                $Gambar = Gambar::where('id_gambar', $data->id_gambar)->first();
                            @endphp

                            @if (!$data->id_gambar)
                                <option selected hidden value="">-- Choose a File Image ---</option>
                                @foreach ($gambar as $item)
                                    <option value="{{$item->id_gambar}}">{{$item->gambar}}</option>
                                @endforeach
                            @else
                                <option selected hidden value="{{$Gambar->id_gambar}}">{{ $Gambar->gambar }}</option>
                                @foreach ($gambar as $item)
                                    <option value="{{$item->id_gambar}}">{{$item->gambar}}</option>
                                @endforeach
                                <option value="">Remove Image From Question</option>
                            @endif
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-sky-800 hover:bg-sky-950 font-semibold rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>

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
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow ">

            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                data-modal-toggle="DeleteSoal">
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
                <form class="modal-form" action="{{url('/DeleteSoalReadingPetugas')}}" method="POST">
                    @csrf
                    <input type="hidden" id="hapus-soal" name="id_soal">
                    
                    <button data-modal-toggle="DeleteSoal" type="button"
                        class="py-2 px-3 text-sm font-semibold text-gray-500 bg-gray-200 rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                        Cancel</button>
                    <input type="submit"
                        class="py-2 px-3 text-sm font-semibold text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900"
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

        document.getElementById('hapus-soal').value = id;
    }

</script>

@endsection