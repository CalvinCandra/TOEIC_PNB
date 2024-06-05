{{-- menghubungkan file main --}}
@extends('peserta.main')

{{-- judul halaman disini --}}
@section('Title', 'Question')

{{-- membuat content disini --}}
@section('content')

<main class="p-5 ml-3 md:ml-64 md:px-14 h-auto pt-20">

  <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="text-left block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
    <h5 class="mb-2 text-2xl font-bold tracking-tight">TOEIC</h5>
    <p class="font-normal text-gray-700">TOEIC is a popular English quiz, because this quiz certificate can be used in various places.</p>
  </button>

</main>


<!-- Main modal -->
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-xl font-semibold">
                  Announcement
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                  </svg>
                  <span class="sr-only">Close modal</span>
              </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-4">
              <h4 class="text-lg text-slate-800 font-semibold">
                The following are the terms and conditions for this quiz:
              </h4>
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <ul class="max-w-xl text-gray-500 list-inside">
                  <li class="mb-1">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>This quiz has 2 categories of questions, namely <b>Reading</b> and <b>Listening</b></span>
                  </li>
                  <li class="mb-1">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>The quiz has a total of <b>100 questions</b>.</span>
                  </li>
                  <li class="mb-1">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>The time required to complete the questions is 120 minutes, which is divided into 2 parts, namely <b>60 minutes for Reading</b> and <b>60 minutes for Listening</b>.</span>
                  </li>
                </ul>
              </p>
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
              <a href="{{url('/soal')}}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Ok, I understand</a>
              <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-red-500 rounded-lg hover:bg-red-400">Cancel</button>
          </div>
      </div>
  </div>
</div>
@endsection