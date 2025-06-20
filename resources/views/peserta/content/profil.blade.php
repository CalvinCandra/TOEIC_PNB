{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Peserta | Profile')

{{-- membuat content disini --}}
@section('content')

<main class="p-5 md:ml-64 md:px-14 h-auto pt-20">

    <div class="my-6">
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
        <h1 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Participant Profile</h1>
        <p>Please review your profile below. Edit the data if necessary as this data will be printed and shown on your
            score report.</p>

        <div class="py-8 px-4 mx-auto w-2xl lg:py-5">
            <form action="{{ url('/UpdateProfil') }}" method="POST">
                @csrf
                <div class="grid gap-4 md:grid-cols-2 md:gap-6">
                    <div class="">
                        <label for="name" class="block mb-2 text-sm font-semibold">Participant Name</label>
                        <input type="text" name="name" id="name" value="{{ $peserta->nama_peserta }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>
                    <div class="">
                        <label for="email" class="block mb-2 text-sm font-semibold">Participant Email</label>
                        <input type="email" name="email" id="email" value="{{ $peserta->user->email }}" disabled
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>
                    <div class="w-full">
                        <label for="nim"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Participant NIM</label>
                        <input type="text" name="nim" id="nim" value="{{ $peserta->nim }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Study
                            Program</label>
                        <select id="category" name="jurusan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="{{ $peserta->jurusan }}" selected hidden>{{ $peserta->jurusan }}</option>
                            <option value="Akutansi">Akutansi</option>
                            <option value="Pariwisata">Pariwisata</option>
                            <option value="Teknik Sipil">Teknik Sipil</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Teknologi Informasi">Teknologi Informasi</option>
                        </select>
                    </div>
                </div>

                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Update Profile
                </button>
            </form>
        </div>
    </div>

</main>
@endsection