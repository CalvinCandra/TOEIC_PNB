{{-- file: resources/views/petugas/halamanutama.blade.php --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Petugas | soal')

{{-- membuat content disini --}}
@section('content')

<main class="p-4 md:ml-64 h-auto pt-20 bg-gray-100">
    <!-- Button to create a new Bank Soal -->
    <div class="flex mb-4 justify-between">
        <a href="/dashPetugasSoal" class="bg-blue-500 px-3 py-1 rounded">
                <i class="fa fa-arrow-left bg-blue-500 hover:bg-blue-700 rounded">
                </i>
        </a>
        <button id="createBankSoal" class="openModal bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" data-id_bank="{{$id_banksoal}}">
            + Soal
        </button>
    </div>
    <div class="overflow-x-auto align-middle text-center rounded-lg shadow">
        <table id="bankSoalTable" class="min-w-full bg-white border border-gray-200">
            <thead class="">
                <tr>
                    <th class="text-left py-3 px-1 uppercase font-semibold text-sm">No
                    <th class="text-left py-3 px-10 uppercase font-semibold text-sm">Soal
                    <th class="text-left py-3 uppercase font-semibold text-sm">Option A
                    <th class="text-left py-3 uppercase font-semibold text-sm">Option B
                    <th class="text-left py-3 uppercase font-semibold text-sm">Option C
                    <th class="text-left py-3 uppercase font-semibold text-sm">Option D
                    <th class="text-left py-3 uppercase font-semibold text-sm">Key
                    <th class="text-left py-3 uppercase font-semibold text-sm">image
                    <th class="text-left py-3 uppercase font-semibold text-sm">Audio
                    <th class="text-left py-3 uppercase font-semibold text-sm">Action
                </tr>
                @foreach($soal as $index => $data)
                <tr>
                    <td class="text-xs py-2">{{$index +1}}</td>
                    <td class="text-xs py-2">{{$data->soal}}</td>
                    <td class="text-xs py-2">{{$data->jawaban_a}}</td>
                    <td class="text-xs py-2">{{$data->jawaban_b}}</td>
                    <td class="text-xs py-2">{{$data->jawaban_c}}</td>
                    <td class="text-xs py-2">{{$data->jawaban_d}}</td>
                    <td class="text-xs py-2">{{$data->kunci_jawaban}}</td>
                    <td class="text-xs py-2">{{$data->id_gambar}}</td>
                    <td class="text-xs py-2">{{$data->id_audio}}</td>
                    <td class="text-xs py-2">
                        <button class="editModal bg-orange-500 hover:bg-orange-700 text-white font-bold p-1 rounded" data-id_soal="{{ $data->id_soal }}" data-soal="{{ $data->soal }}" data-jawaban_a="{{ $data->jawaban_a }}" data-jawaban_b="{{ $data->jawaban_b }}" data-jawaban_c="{{ $data->jawaban_c }}" data-jawaban_d="{{ $data->jawaban_d }}" data-kunci_jawaban="{{ $data->kunci_jawaban }}" data-id_gambar="{{ $data->id_gambar }}" data-id_audio="{{ $data->id_audio }}">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <a href="/delete-soal/{{$data->id_soal}}" class="bg-red-700 hover:bg-orange-700 text-white font-bold p-1 rounded">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach   
            </thead>
        </table>
</main>

<!-- Modal for input soal -->
<div id="inputSoalModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Form Input Soal</h3>
                        <div class="mt-2">
                            <form id="formInputSoal" action="{{ route('simpan-soal') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Save id bank soal -->
                                <input type="text" name="id_bank" id="id_bank" >
                                <div class="mb-4">
                                    <label for="soal" class="block text-gray-700 font-bold mb-2">Soal:</label>
                                    <textarea id="soal" name="soal" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan soal"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_a" class="block text-gray-700 font-bold mb-2">Jawaban A:</label>
                                    <input type="text" id="jawaban_a" name="jawaban_a" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban A">
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_b" class="block text-gray-700 font-bold mb-2">Jawaban B:</label>
                                    <input type="text" id="jawaban_b" name="jawaban_b" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban B">
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_c" class="block text-gray-700 font-bold mb-2">Jawaban C:</label>
                                    <input type="text" id="jawaban_c" name="jawaban_c" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban C">
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_d" class="block text-gray-700 font-bold mb-2">Jawaban D:</label>
                                    <input type="text" id="jawaban_d" name="jawaban_d" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban D">
                                </div>
                                <div class="mb-4">
                                    <label for="kunci_jawaban" class="block text-gray-700 font-bold mb-2">Kunci Jawaban:</label>
                                    <select id="kunci_jawaban" name="kunci_jawaban" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Kategori:</label>
                                    @if(isset($kategoris))
                                        @foreach($kategoris as $category)
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="kategori" value="{{ $category->id_kategori }}" class="form-radio h-5 w-5 text-blue-600">
                                                <span class="ml-2">{{ $category->kategori }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        <p>No categories available.</p>
                                    @endif

                                </div>
                                <div class="mb-4">
                                    <label for="gambar" class="block text-gray-700 font-bold mb-2">Gambar (optional):</label>
                                    <input type="file" id="gambar" name="gambar" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="mb-4">
                                    <label for="audio" class="block text-gray-700 font-bold mb-2">Audio (optional):</label>
                                    <input type="file" id="audio" name="audio" accept="audio/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Simpan Soal
                                    </button>
                                    <button type="button" id="closeModal" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for edit soal -->
<div id="editSoalModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Form Input Soal</h3>
                        <div class="mt-2">
                            <form id="formEditSoal" action="/update-soal" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!-- Hidden input -->
                                <input type="text" name="id_soal" id="id_soal">
                                <input type="text" name="id_gambar" id="id_gambar">
                                <input type="text" name="id_audio" id="id_audio">
                                
                                <div class="mb-4">
                                    <label for="soal" class="block text-gray-700 font-bold mb-2">Soal:</label>
                                    <textarea id="soal" name="soal" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan soal"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_a" class="block text-gray-700 font-bold mb-2">Jawaban A:</label>
                                    <input type="text" id="jawaban_a" name="jawaban_a" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban A">
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_b" class="block text-gray-700 font-bold mb-2">Jawaban B:</label>
                                    <input type="text" id="jawaban_b" name="jawaban_b" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban B">
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_c" class="block text-gray-700 font-bold mb-2">Jawaban C:</label>
                                    <input type="text" id="jawaban_c" name="jawaban_c" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban C">
                                </div>
                                <div class="mb-4">
                                    <label for="jawaban_d" class="block text-gray-700 font-bold mb-2">Jawaban D:</label>
                                    <input type="text" id="jawaban_d" name="jawaban_d" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan jawaban D">
                                </div>
                                <div class="mb-4">
                                    <label for="kunci_jawaban" class="block text-gray-700 font-bold mb-2">Kunci Jawaban:</label>
                                    <select id="kunci_jawaban" name="kunci_jawaban" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Kategori:</label>
                                    @if(isset($kategoris))
                                        @foreach($kategoris as $category)
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="kategori" value="{{ $category->id_kategori }}" class="form-radio h-5 w-5 text-blue-600">
                                                <span class="ml-2">{{ $category->kategori }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        <p>No categories available.</p>
                                    @endif

                                </div>
                                <div class="mb-4">
                                    <label for="gambar" class="block text-gray-700 font-bold mb-2">Gambar (optional):</label>
                                    <input type="file" id="gambar_new" name="gambar_new" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="mb-4">
                                    <label for="audio" class="block text-gray-700 font-bold mb-2">Audio (optional):</label>
                                    <input type="file" id="audio_new" name="audio_new" accept="audio/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Simpan Soal
                                    </button>
                                    <button type="button" id="closeModal" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('.openModal').click(function(){
            $('#inputSoalModal').removeClass('hidden');
    });

    $('.editModal').click(function(){
            console.log('edit')
            $('#editSoalModal').removeClass('hidden');
    });

    $(document).ready(function() {
            $('.openModal').click(function() {
                let idBankSoal = $(this).data('id_bank');
                console.log('Button clicked, id_bank:', idBankSoal);
                if(idBankSoal !== undefined){
                    $('#id_bank').val(idBankSoal);
                    $('#inputSoalModal').removeClass('hidden');
                } else {
                    console.error('idBankSoal is undefined');
                }
            });

            $('#closeModal').click(function() {
                $('#inputSoalModal').addClass('hidden');
            });
        });

    $(document).ready(function() {
            $('.editModal').click(function() {
                let id_soal = $(this).data('id_soal');
                let soal = $(this).data('soal');
                let jawaban_a = $(this).data('jawaban_a');
                let jawaban_b = $(this).data('jawaban_b');
                let jawaban_c = $(this).data('jawaban_c');
                let jawaban_d = $(this).data('jawaban_d');
                let kunci_jawaban = $(this).data('kunci_jawaban');
                let id_gambar = $(this).data('id_gambar');
                let id_audio = $(this).data('id_audio');
                console.log('Button edit : ', soal, jawaban_a, jawaban_b, jawaban_c, jawaban_d);
                if(soal !== undefined){
                    console.log('work?');
                    $('#editSoalModal #id_soal').val(id_soal);
                    $('#editSoalModal #soal').val(soal);
                    $('#editSoalModal #jawaban_a').val(jawaban_a);
                    $('#editSoalModal #jawaban_b').val(jawaban_b);
                    $('#editSoalModal #jawaban_c').val(jawaban_c);
                    $('#editSoalModal #jawaban_d').val(jawaban_d);
                    $('#editSoalModal #kunci_jawaban').val(kunci_jawaban);
                    $('#editSoalModal #id_gambar').val(id_gambar);
                    $('#editSoalModal #id_audio').val(id_audio);
                    $('#editSoalModal').removeClass('hidden');
                } else {
                    console.error('Soal is undefined');
                }
            });

            $('#closeModal').click(function() {
                $('#inputSoalModal').addClass('hidden');
            });
        });

</script>

@endsection