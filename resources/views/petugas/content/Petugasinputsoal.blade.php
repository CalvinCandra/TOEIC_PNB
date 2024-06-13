{{-- menghubungkan file main --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Petugas | Input Soal')

{{-- membuat content disini --}}
@section('content')
{{-- file: resources/views/petugasinputsoal.blade.php --}}
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
                                    @foreach($kategoris as $category)
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="kategori" value="{{ $category->id_kategori }}" class="form-radio h-5 w-5 text-blue-600">
                                            <span class="ml-2">{{ $category->kategori }}</span>
                                        </label>
                                    @endforeach
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

@endsection
