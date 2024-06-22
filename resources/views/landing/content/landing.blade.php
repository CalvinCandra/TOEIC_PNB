{{-- menghubungkan file main --}}
@extends('landing.main')

{{-- judul halaman disini --}}
@section('Title', 'TOEIC PNB')

{{-- membuat content disini --}}
@section('content')
    {{-- Hero section --}}
    <section class="bg-gradient-to-l from-blue-400 via-blue-400 to-sky-800 dark:bg-gray-900 mt-12 h-screen" id="home">
        <div class="flex items-center justify-center h-full">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div
                    class="mr-auto place-self-center lg:col-span-7 flex flex-col justify-center items-center lg:items-start text-center lg:text-left">
                    <h1
                        class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-white dark:text-white">
                        Try the Web TOEIC Test Simulation!</h1>
                    <p class="max-w-2xl mb-6 font-light text-white lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                        Improve your TOEIC score easily and effectively</p>
                    <a href="{{ url('/DashboardSoal') }}"
                        class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-[#FB8500] hover:bg-[#D97300] focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                        Starting Now
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                    <img src="{{ asset('img/hero.png') }}" alt="mockup">
                </div>
            </div>
        </div>
    </section>

    {{-- Apa itu toeic --}}
    <section class="bg-white dark:bg-gray-900 mt-9 min-h-screen" id="about">
        <div class="flex items-center justify-center h-full">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12 my-8">
                <h1
                    class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-gray-900 md:text-4xl lg:text-5xl dark:text-white">
                    What is TOEIC?</h1>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">TOEIC is
                    an acronym for Test of English for International Communication. The test is designed to measure a
                    person's ability to use English in a professional context. It is widely used by companies and
                    organizations to assess the English language proficiency of their employees and job applicants.</p>

                <div class="mx-auto text-center md:max-w-screen-md lg:max-w-screen-lg ">
                    <span class="font-extrabold text-gray-900 uppercase lg:text-3xl text-2xl">Why TOEIC is Important?</span>

                    <!-- Carousel tampilan mobile -->
                    <div class="lg:hidden w-full mt-8">
                        <div id="default-carousel" class="relative w-full z-10" data-carousel="slide">
                            <!-- Carousel wrapper -->
                            <div class="relative h-80 overflow-hidden rounded-lg md:h-96">
                                <!-- Item 1 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <div class="flex flex-col items-center justify-center h-full">
                                        <img src="{{ asset('img/benefit 1.png') }}" class="block w- h-3/4 object-contain"
                                            alt="Standar Kebutuhan Industri">
                                        <span class="font-bold mb-2 text-gray-700 dark:text-gray-400">Industry Requirements
                                            Standard</span>
                                    </div>
                                </div>
                                <!-- Item 2 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <div class="flex flex-col items-center justify-center h-full">
                                        <img src="{{ asset('img/benefit 2.png') }}" class="block w-3/4 h-3/4 object-contain"
                                            alt="Booster Kepercayaan Diri">
                                        <span class="font-bold mb-2 text-gray-700 dark:text-gray-400">Self-Confidence
                                            Booster</span>
                                    </div>
                                </div>
                                <!-- Item 3 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <div class="flex flex-col items-center justify-center h-full">
                                        <img src="{{ asset('img/benefit 3.png') }}" class="block w-3/4 h-3/4 object-contain"
                                            alt="Asah Kemampuan Bahasa Inggris">
                                        <span class="font-bold mb-2 text-gray-700 dark:text-gray-400">Improve Your English
                                            Skills</span>
                                    </div>
                                </div>
                                <!-- Item 4 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <div class="flex flex-col items-center justify-center h-full">
                                        <img src="{{ asset('img/benefit 4.png') }}" class="block w-3/4 h-3/4 object-contain"
                                            alt="Menonjolkan Kemampuan Komunikasi">
                                        <span class="font-bold mb-2 text-gray-700 dark:text-gray-400">Improve Communication
                                            Skill</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Slider indicators -->
                            <div
                                class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                                    data-carousel-slide-to="0"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 2" data-carousel-slide-to="1"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 3" data-carousel-slide-to="2"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 4" data-carousel-slide-to="3"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 5" data-carousel-slide-to="4"></button>
                            </div>
                            <!-- Slider controls -->
                            <button type="button"
                                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-prev>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/25 dark:bg-gray-800/30 group-hover:bg-black dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4"></path>
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button"
                                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-next>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/25 dark:bg-gray-800/30 group-hover:bg-black dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Gambar Tampilan Dekstop -->
                    <div class="hidden lg:flex flex-wrap justify-center items-start mt-8 text-gray-500 sm:justify-between">
                        <div
                            class="flex flex-col items-center mb-5 lg:mb-0 hover:text-gray-800 dark:hover:text-gray-400 flex-shrink-0 w-full md:w-1/2 lg:w-1/4 xl:w-1/4">
                            <img src="{{ asset('img/benefit 1.png') }}"
                                class="max-w-full h-48 object-cover transition-transform duration-300 transform hover:scale-110"
                                alt="Standar Kebutuhan Industri">
                            <span class="block mt-2 w-48 text-center font-bold">Industry Requirements Standard</span>
                        </div>
                        <div
                            class="flex flex-col items-center mb-5 lg:mb-0 hover:text-gray-800 dark:hover:text-gray-400 flex-shrink-0 w-full md:w-1/2 lg:w-1/4 xl:w-1/4">
                            <img src="{{ asset('img/benefit 2.png') }}"
                                class="max-w-full h-48 object-cover transition-transform duration-300 transform hover:scale-110"
                                alt="Booster Kepercayaan Diri">
                            <span class="block mt-2 w-48 text-center font-bold">Self-Confidence<br>Booster</span>
                        </div>
                        <div
                            class="flex flex-col items-center mb-5 lg:mb-0 hover:text-gray-800 dark:hover:text-gray-400 flex-shrink-0 w-full md:w-1/2 lg:w-1/4 xl:w-1/4">
                            <img src="{{ asset('img/benefit 3.png') }}"
                                class="max-w-full h-48 object-cover transition-transform duration-300 transform hover:scale-110"
                                alt="Asah Kemampuan Bahasa Inggris">
                            <span class="block mt-2 w-48 text-center font-bold">Improve Your English Skills</span>
                        </div>
                        <div
                            class="flex flex-col items-center mb-5 lg:mb-0 hover:text-gray-800 dark:hover:text-gray-400 flex-shrink-0 w-full md:w-1/2 lg:w-1/4 xl:w-1/4">
                            <img src="{{ asset('img/benefit 4.png') }}"
                                class="max-w-full h-48 object-cover transition-transform duration-300 transform hover:scale-110"
                                alt="Menonjolkan Kemampuan Komunikasi">
                            <span class="block mt-2 w-48 text-center font-bold">Improve Communication Skill</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Cakupan simulasi TOEIC --}}
    <section class="relative min-h-screen">
        {{-- gambar latar --}}
        <div class="absolute top-0 left-0 w-full h-[60%] bg-cover bg-center"
            style="background-image: url('{{ asset('img/laptop.jpg') }}');">
            {{-- overlay hitam --}}
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>

        {{-- warna bagian bawah gambar latar --}}
        <div class="absolute bottom-0 left-0 w-full h-[40%] bg-black opacity-30"></div>

        {{-- konten utama --}}
        <div class="relative flex flex-col justify-center items-center z-10 h-full">
            <div class="relative w-full mx-auto py-8 px-4 sm:px-8 lg:px-56 grid grid-cols-1 lg:grid-cols-2 gap-8 mt-6">
                {{-- konten teks --}}
                <div class="flex flex-col justify-center text-white text-center lg:text-left px-4">
                    <h2 class="text-3xl lg:text-4xl font-extrabold mb-4">TOEIC Simulation<br>Test Coverage</h2>
                    <span class="text-lg lg:text-xl">This TOEIC simulation test covers part</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    {{-- Konten kotak informasi reading --}}
                    <div class="bg-white text-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold mb-4 text-center">Reading</h3>
                        <ul class="list-none space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-circle text-black mr-3"></i>
                                <span>50 questions</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-circle text-black mr-3"></i>
                                <span>100 minutes</span>
                            </li>
                        </ul>
                    </div>
                    {{-- Konten kotak informasi Listening --}}
                    <div class="bg-white text-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold mb-4 text-center">Listening</h3>
                        <ul class="list-none space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-circle text-black mr-3"></i>
                                <span>50 questions</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-circle text-black mr-3"></i>
                                <span>100 minutes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- tahapan tes --}}
            <div class="relative z-20 mt-16 mb-5 w-full px-4 sm:px-8 md:px-16 lg:px-[225px]">
                <div class="container mx-auto">
                    <div class="w-full bg-white shadow-lg p-5 rounded-xl">
                        <div>
                            <div class="text-lg font-bold mb-7 text-center">
                                <span>Steps for Simulation Test</span>
                            </div>
                            <section class="flex flex-wrap justify-between">
                                <div class="w-full sm:w-1/2 lg:w-1/5 text-center mb-4 flex flex-col items-center">
                                    <div class="mb-4">
                                        <img loading="lazy" decoding="async" width="85" height="85"
                                            src="{{ asset('favicon/form.png') }}" alt="">
                                    </div>
                                    <div class="text-lg font-bold mb-2">
                                        <span>Follow Test Rules</span>
                                    </div>
                                    <div class="text-base">
                                        <span>Understand and follow the test rules for smooth testing</span>
                                    </div>
                                </div>
                                <div class="hidden md:flex md:w-1/5 text-center mb-4 items-center justify-center">
                                    <div class="h-full flex items-center mb-28">
                                        <img loading="lazy" decoding="async" width="180" height="25"
                                            src="{{ asset('favicon/panah.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 lg:w-1/5 text-center mb-4 flex flex-col items-center">
                                    <div class="mb-4">
                                        <img loading="lazy" decoding="async" width="85" height="85"
                                            src="{{ asset('favicon/create.png') }}" alt="">
                                    </div>
                                    <div class="text-lg font-bold mb-2">
                                        <span>Work the Test</span>
                                    </div>
                                    <div class="text-base">
                                        <span><i>Reading</i> and <i>Listening</i> with an <b>estimated time of 200
                                                minutes</b></span>
                                    </div>
                                </div>
                                <div class="hidden md:flex md:w-1/5 text-center mb-4 items-center justify-center">
                                    <div class="h-full flex items-center lg:mb-28">
                                        <img loading="lazy" decoding="async" width="180" height="25"
                                            src="{{ asset('favicon/panah.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="w-full sm:w-1/2 lg:w-1/5 text-center mb-4 flex flex-col items-center">
                                    <div class="mb-4">
                                        <img loading="lazy" decoding="async" width="85" height="85"
                                            src="{{ asset('favicon/share.png') }}" alt="">
                                    </div>
                                    <div class="text-lg font-bold mb-2">
                                        <span>Sharing Test Results</span>
                                    </div>
                                    <div class="text-base">
                                        <span>Share your test results on social media!</i></span>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section>
        <div class="container mx-auto my-10 p-5">
            <h2 class="text-3xl font-bold mb-10 text-center">Frequently Asked Questions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="accordion-collapse" data-accordion="collapse">
                {{-- FAQ 1 --}}
                <div>
                    <h2 id="accordion-collapse-heading-1">
                        <button type="button"
                            class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                            data-accordion-target="#accordion-collapse-body-1" aria-expanded="false"
                            aria-controls="accordion-collapse-body-1">
                            <span class="flex-grow text-center">Why TOEIC?</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-1" class="hidden overflow-hidden transition-all duration-300"
                        aria-labelledby="accordion-collapse-heading-1">
                        <div class="p-5 border border-t-0 border-gray-200 bg-gray-50 s">
                            <p class="mb-2 text-gray-500">The TOEIC test is a very useful tool for individuals who want to
                                prove their English language skills in a professional context. It helps enhance career
                                opportunities, provides global recognition, and offers an objective assessment of English
                                language proficiency. For companies, this test is a reliable way to evaluate and improve
                                their employees' communication skills, ultimately contributing to overall business success.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div>
                    <h2 id="accordion-collapse-heading-2">
                        <button type="button"
                            class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                            data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                            aria-controls="accordion-collapse-body-2">
                            <span class="flex-grow text-center">Can I take the test at home?</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-2" class="hidden overflow-hidden transition-all duration-300"
                        aria-labelledby="accordion-collapse-heading-2">
                        <div class="p-5 border border-t-0 border-gray-200 bg-gray-50">
                            <p class="mb-2 text-gray-500">You can easily take a simulated TOEIC test from the comfort of
                                your home. Simply ensure you have a stable internet connection, then follow the provided
                                instructions to start the test. With this method, you can practice anytime and prepare
                                yourself better for the actual exam.</p>
                        </div>
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div>
                    <h2 id="accordion-collapse-heading-3">
                        <button type="button"
                            class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                            data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                            aria-controls="accordion-collapse-body-3">
                            <span class="flex-grow text-center">Will I receive a certificate?</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-3" class="hidden overflow-hidden transition-all duration-300"
                        aria-labelledby="accordion-collapse-heading-3">
                        <div class="p-5 border border-t-0 border-gray-200 bg-gray-50">
                            <p class="mb-2 text-gray-500">For this simulated TOEIC test, you will not receive a
                                certificate. However, you will receive your test scores, which will be sent to you via
                                email, allowing you to share your results on social media. Additionally, you will be
                                provided with explanations for both correct and incorrect answers.</p>
                        </div>
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div>
                    <h2 id="accordion-collapse-heading-4">
                        <button type="button"
                            class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 bg-white border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                            data-accordion-target="#accordion-collapse-body-4" aria-expanded="false"
                            aria-controls="accordion-collapse-body-4">
                            <span class="flex-grow text-center">Will the test result data be provided?</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-4" class="hidden overflow-hidden transition-all duration-300"
                        aria-labelledby="accordion-collapse-heading-4">
                        <div class="p-5 border border-t-0 border-gray-200 bg-gray-50">
                            <p class="mb-2 text-gray-500">Yes, the test result data will be provided, and you can view it
                                directly on the website or through an email from us. You will receive your test results once
                                you have completed the test. Additionally, you will be informed of the score category you
                                have achieved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
