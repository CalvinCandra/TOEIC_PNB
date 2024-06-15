{{-- file: resources/views/petugas/halamanutama.blade.php --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Petugas | banksoal')

{{-- membuat content disini --}}
@section('content')
<main class="p-4 md:ml-64 h-auto pt-20 bg-gray-100">
    <!-- Button to create a new Bank Soal -->
    <div class="flex justify-end mb-4">
        <button id="createBankSoal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Bank Soal
        </button>
    </div>

    <!-- Table for Bank Soal -->
    <div class="overflow-x-auto">
        <table id="bankSoalTable" class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200 border-b">Bank Soal</th>
                    <th class="py-2 px-4 bg-gray-200 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $bankSoal)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $bankSoal->bank }}</td>
                    <td class="py-2 px-4 border-b">
                        <div class="flex justify-end mb-4">
                            <button class="openModal bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-id_bank="{{$bankSoal->id_bank}}">
                                Buat Soal
                            </button>
                        </div>
                        <div class="flex justify-end mb-4">
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-id_bank="{{$bankSoal->id_bank}}">
                                Hapus Bank Soal
                            </button>
                        </div>
                        <div class="flex justify-end mb-4">
                            <a href="/dashPetugasBankSoal/{{$bankSoal->id_bank}}" class="lihatSoal bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Detail Soal
                            </a>
                        </div>
                        <div class="flex justify-end mb-4">
                            <button class="lihatSoal bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" data-id="{{ $bankSoal->id_bank }}">
                                Lihat Soal
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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

<!-- Modal for viewing soal -->
<div id="lihatSoalModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">List Soal</h3>
                        <div id="soalList" class="mt-2">
                            <!-- Buttons will be appended here via JavaScript -->
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button type="button" id="closeLihatSoalModal" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#createSoal').click(function(){
            $('#inputSoalModal').removeClass('hidden');
        });

        $('.openModal').click(function(){
            $('#inputSoalModal').removeClass('hidden');
        });

        $('#closeModal').click(function(){
            $('#inputSoalModal').addClass('hidden');
        });

        $('.lihatSoal').click(function(){
            var idBankSoal = $(this).data('id');
            $.ajax({
                url: '/lihat-soal/' + idBankSoal,
                method: 'GET',
                success: function(data) {
                    $('#soalList').empty();
                    data.forEach(function(soal, index) {
                        $('#soalList').append('<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">Soal ' + (index + 1) + '</button>');
                    });
                    $('#lihatSoalModal').removeClass('hidden');
                }
            });
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


        $('#createBankSoal').click(function(){
            $.ajax({
                url: '{{ route("bank-soal.create") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let newRow = `
                        <tr>
                            <td class="py-2 px-4 border-b">${response.bank}</td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex justify-end mb-4">
                                    <a href="{{ url('/TambahPetugasSoal') }}">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Buat Soal
                                        </button>
                                    </a>
                                </div>
                                <div class="flex justify-end mb-4">
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus Bank Soal
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                    $('#bankSoalTable tbody').append(newRow);
                }
            });
        });

        $('#closeLihatSoalModal').click(function(){
            $('#lihatSoalModal').addClass('hidden');
        });
    });
</script>
@endsection
