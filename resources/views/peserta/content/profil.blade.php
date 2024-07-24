{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Peserta | Profile')

{{-- membuat content disini --}}
@section('content')

<main class="p-5 md:ml-64 md:px-14 h-auto pt-20">

    <div class="my-6"> 
        @if (count($errors) > 0)
            <div id="alert-2" class="flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="ml-3 text-sm font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      <h1 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Participant Profile</h1>
      <p>Please check whether the data below is correct or not. If not, please edit the following data.</p>

      <div class="py-8 px-4 mx-auto w-2xl lg:py-5">
          <form action="{{url('/UpdateProfil')}}" method="POST">
            @csrf
              <div class="grid gap-4 md:grid-cols-2 md:gap-6">
                  <div class="">
                      <label for="name" class="block mb-2 text-sm font-semibold">Participant Name</label>
                      <input type="text" name="name" id="name" value="{{$peserta->nama_peserta}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                  </div>
                  <div class="">
                      <label for="email" class="block mb-2 text-sm font-semibold">Participant Email</label>
                      <input type="email" name="email" id="email" value="{{$peserta->user->email}}" disabled class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                  </div>
                  <div class="w-full">
                      <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Participant NIM</label>
                      <input type="text" name="nim" id="nim" value="{{$peserta->nim}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                  </div>
                  <div>
                      <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mayor</label>
                      <select id="category" name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                          <option value="{{$peserta->jurusan}}" selected hidden>{{$peserta->jurusan}}</option>
                          <option value="Akutansi">Akutansi</option>
                          <option value="Pariwisata">Pariwisata</option>
                          <option value="Teknik Sipil">Teknik Sipil</option>
                          <option value="Teknik Mesin">Teknik Mesin</option>
                          <option value="Teknik Elektro">Teknik Elektro</option>
                          <option value="Teknologi Informasi">Teknologi Informasi</option>
                      </select>
                  </div>

                  @if ($peserta->kelamin == 'L')
                    <div class="w-full">
                        <label for="name" class="block mb-2 text-sm font-semibold">Participant Gender</label>
                        <div class="flex items-center mb-4">
                            <input checked id="default-radio-1" type="radio" value="L" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><i class="fa-solid fa-mars"></i> Man</label>
                        </div>
                        <div class="flex items-center">
                            <input id="default-radio-2" type="radio" value="P" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><i class="fa-solid fa-venus"></i> Female</label>
                        </div>
                    </div>
                  @else
                    <div class="w-full">
                        <label for="name" class="block mb-2 text-sm font-semibold">Participant Gender</label>
                        <div class="flex items-center mb-4">
                            <input id="default-radio-1" type="radio" value="L" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><i class="fa-solid fa-mars"></i> Male</label>
                        </div>
                        <div class="flex items-center">
                            <input checked id="default-radio-2" type="radio" value="P" name="kelamin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><i class="fa-solid fa-venus"></i> Female</label>
                        </div>
                    </div>
                  @endif
                  
              </div>

            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                Update Profile
            </button>
          </form>
      </div>
    </div>

  </main>
@endsection