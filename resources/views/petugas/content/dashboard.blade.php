{{-- menghubungkan file main --}}
@extends('petugas.main')

{{-- judul halaman disini --}}
@section('Title', 'Dashboard Petugas')

{{-- membuat content disini --}}
@section('content')
<main class="p-4 md:ml-64 h-auto pt-20 bg-re">

  <div class="p-4 mb-4 text-white rounded-lg bg-green-500" role="alert">
    <h3 class="text-lg font-bold italic">Welcome, Petugas</h3>
  </div>

  {{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
    <div class="border-2 border-dashed border-gray-300 rounded-lg h-32 md:h-64">

    </div>

    <div
      class="border-2 border-dashed rounded-lg border-gray-300 h-32 md:h-64"
    ></div>
    <div
      class="border-2 border-dashed rounded-lg border-gray-300 h-32 md:h-64"
    ></div>
    <div
      class="border-2 border-dashed rounded-lg border-gray-300 h-32 md:h-64"
    ></div>
  </div> --}}

</main>
@endsection