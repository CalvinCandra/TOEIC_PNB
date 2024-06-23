<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')
    @include('layouts.header')


    <title>Test Score</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Add Flowbite CSS -->
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    {{-- disable back button --}}
    <script type="text/javascript">
        window.history.forward(1);
    </script>
</head>

<body class="bg-gray-100">
    {{-- header --}}
    <div class="mx-auto w-full max-w-screen-xl p-4">
        <p class="text-2xl md:flex md:justify-between md:items-start text-center md:text-left">Hi,
            {{ $peserta->nama_peserta }}</p>
        <p class="mt-2 font-bold text-4xl md:flex md:justify-between md:items-start text-center md:text-left">Here's a
            simulation of the TOEIC test you did.</p>
        <p class="text-lg pt-1 md:flex md:justify-between md:items-start text-center md:text-left">See the scores and
            results you've obtained in Starting TOEIC test</p>
        <p
            class="font-bold pt-4 text-lg text-[#b1b1b1] md:flex md:justify-between md:items-start text-center md:text-left italic">
            *The test results are not a certificate*</p>
    </div>

    <!-- Score -->
    <div class="px-4 mt-5 mx-auto w-full max-w-screen-xl">
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            {{-- TOTAL SCORE --}}
            <div
                class="p-4 bg-white border-2 border-gray-300 rounded-md shadow-sm md:w-[30%] flex flex-col items-center justify-center">
                <h5 class="mb-2 text-2xl font-bold text-center">TOTAL SCORE</h5>
                <p class="font-bold text-6xl text-center">{{ $totalSkor }}</p>
            </div>

            {{-- LISTENING AND READING SCORE --}}
            <div class="flex-grow p-4 bg-white border-2 border-gray-300 rounded-md shadow-sm md:w-[70%]">
                <!-- Listening Score -->
                <div class="mb-4">
                    <div class="flex justify-between">
                        <span class="font-bold p-2 rounded-md bg-[#FFB703] px-4">LISTENING</span>
                    </div>
                    <div class="flex items-center mt-3">
                        <div class="bg-gray-200 h-5 flex-grow">
                            <div id="progress-bar-1" class="bg-blue-500 h-5"></div>
                        </div>
                        <span id="score-1" class="font-bold ml-4"></span>
                    </div>
                </div>

                <!-- Reading Score -->
                <div class="mb-4">
                    <div class="flex justify-between">
                        <span class="font-bold p-2 rounded-md bg-[#FFB703] px-5">READING</span>
                    </div>
                    <div class="flex items-center mt-3">
                        <div class="bg-gray-200 h-5 flex-grow">
                            <div id="progress-bar-2" class="bg-blue-500 h-5"></div>
                        </div>
                        <span id="score-2" class="font-bold ml-4"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Description -->
    <div class="p-4 mx-auto w-full max-w-screen-xl">
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            {{-- YOUR RESULT --}}
            <div class="md:w-[30%] overflow-hidden">
                <p class="font-semibold text-base mb-2">Your Result</p>
                <div class="w-full mx-auto bg-[#bbdae8] rounded-lg">
                    <p class="text-center p-4 text-bold text-xl font-extrabold text-[#6CB8DC]">{{ $kategori }}</p>
                </div>
                <div class="flex items-center space-x-4 mt-3 mb-3">
                    <img src="{{ asset('favicon/sendMail.png') }}" alt="SendEmail" style="width: 50px;">
                    <div class="mail">
                        <p class="font-normal">Your results have been sent to</p>
                        <p class="font-bold">{{ $peserta->user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- AN EXPLANATION --}}
            <div class="flex-grow p-4 bg-white border-2 border-gray-300 rounded-md shadow-sm md:w-[70%]">
                <p class="font-semibold mb-3 text-2xl">AN EXPLANATION OF YOUR NATURE</p>
                <p class="font-bold text-gray-500 text-xl">{{ $kategori }}</p>
                <p class="font-semibold text-base mt-0 text-[#219EBC]">TOEIC score range of {{ $rangeSkor }}</p>
                <div class="w-full bg-black h-0.5 mt-3 mb-2"></div>
                <p class="mb-6">{{ $detail }}</p>
                <div class="text-center">
                    <a href="{{ url('/destory') }}"
                        class="block w-full p-2 rounded-lg text-white bg-blue-500 hover:bg-blue-800">Back</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Result Categories -->
    <div class="px-4 pb-5 mx-auto w-full max-w-screen-xl">
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <div class="md:w-[30%] hidden md:block"></div>
            <div class="flex-grow p-4 bg-white border-2 border-gray-300 rounded-md shadow-sm md:w-[70%]">
                <p class="font-bold text-2xl mb-4 mt-3 text-center">OTHER RESULT CATEGORIES</p>

                <div id="accordion-flush" data-accordion="collapse"
                    data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                    data-inactive-classes="text-gray-500 dark:text-gray-400">

                    <!-- International Proficiency -->
                    <h2 id="accordion-flush-heading-1">
                        <button type="button"
                            class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-1" aria-expanded="false"
                            aria-controls="accordion-flush-body-1">
                            <div class="text-left">
                                <p class="text-xl text-gray-500 font-semibold">
                                    International Proficiency</p>
                                <p class="text-sm text-[#219EBC] font-bold">TOEIC
                                    score
                                    range of 905 - 990</p>
                            </div>
                            <svg data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-1" class="hidden flex-grow"
                        aria-labelledby="accordion-flush-heading-1">
                        <div class="py-4 border-b border-gray-200 dark:border-gray-700">
                            <p class="mb-2 text-gray-500 dark:text-gray-400">This range of values indicates that the
                                individual has a very high ability to speak English. They are able to communicate
                                smoothly
                                and effectively in a variety of professional and academic contexts. People in this
                                category
                                can easily understand complex texts, follow quick conversations, and express themselves
                                clearly and persuasively. They can interact with native and non-native English speakers
                                with
                                confidence, using extensive vocabulary and complex sentence structure.</p>
                        </div>
                    </div>

                    <!-- Working Proficiency Plus -->
                    <h2 id="accordion-flush-heading-2">
                        <button type="button"
                            class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-2" aria-expanded="false"
                            aria-controls="accordion-flush-body-2">
                            <div class="text-left">
                                <p class="text-xl text-gray-500 font-semibold">
                                    Working Proficiency Plus</p>
                                <p class="text-sm text-[#219EBC] font-bold">TOEIC
                                    score
                                    range of 785 - 900</p>
                            </div>
                            <svg data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                            <p class="mb-2 text-gray-500 dark:text-gray-400">This range of values indicates excellent
                                English proficiency for professional needs. Individuals in this category are able to
                                communicate smoothly in various work and daily life situations. They can understand
                                relatively complex texts, follow in-depth discussions, and convey ideas clearly and
                                organizedly. They may still require a little adaptation to interact in very formal or
                                technical situations, but generally they can perform English tasks well.</p>
                        </div>
                    </div>

                    <!-- Limited Working Proficiency -->
                    <h2 id="accordion-flush-heading-3">
                        <button type="button"
                            class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-3" aria-expanded="false"
                            aria-controls="accordion-flush-body-3">
                            <div class="text-left">
                                <p class="text-xl text-gray-500 font-semibold">
                                    Limited Working Proficiency</p>
                                <p class="text-sm text-[#219EBC] font-bold">TOEIC
                                    score
                                    range of 605 - 780</p>
                            </div>
                            <svg data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                            <p class="mb-2 text-gray-500 dark:text-gray-400">This range of values reflects an adequate
                                English language proficiency for basic work situations. People with values in this
                                category
                                may be able to communicate in everyday contexts and may be capable of completing simple
                                tasks using English. They can understand clear instructions and participate in not too
                                complex conversations, although they may have difficulty with more technical material or
                                in-depth discussions.</p>
                        </div>
                    </div>

                    <!-- Elementary Proficiency Plus -->
                    <h2 id="accordion-flush-heading-4">
                        <button type="button"
                            class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-4" aria-expanded="false"
                            aria-controls="accordion-flush-body-4">
                            <div class="text-left">
                                <p class="text-xl text-gray-500 font-semibold">
                                    Elementary Proficiency Plus</p>
                                <p class="text-sm text-[#219EBC] font-bold">TOEIC
                                    score
                                    range of 405 - 600</p>
                            </div>
                            <svg data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-4" class="hidden" aria-labelledby="accordion-flush-heading-4">
                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                            <p class="mb-2 text-gray-500 dark:text-gray-400">This range of values indicates basic
                                English
                                skills. Individuals with values here may have a basic understanding of the English
                                structure
                                and commonly used vocabulary. They can understand simple texts and communicate in
                                limited
                                contexts, such as talking about everyday topics or routine work tasks. They may need
                                extra
                                time to process more complex information or to express ideas clearly.</p>
                        </div>
                    </div>

                    <!-- Elementary Proficiency -->
                    <h2 id="accordion-flush-heading-5">
                        <button type="button"
                            class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-5" aria-expanded="false"
                            aria-controls="accordion-flush-body-5">
                            <div class="text-left">
                                <p class="text-xl text-gray-500 font-semibold">
                                    Elementary Proficiency</p>
                                <p class="text-sm text-[#219EBC] font-bold">TOEIC
                                    score
                                    range of 255 - 400</p>
                            </div>
                            <svg data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-5" class="hidden" aria-labelledby="accordion-flush-heading-5">
                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                            <p class="mb-2 text-gray-500 dark:text-gray-400">This range of values reflects very limited
                                English skills. Individuals with values here may be able to understand simple sentences
                                and
                                participate in very limited conversations. They may be able to perform basic tasks such
                                as
                                filling out forms or delivering very general information, but they will have difficulty
                                understanding longer or more complex texts.</p>
                        </div>
                    </div>

                    <!-- Memorised Proficiency -->
                    <h2 id="accordion-flush-heading-6">
                        <button type="button"
                            class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-6" aria-expanded="false"
                            aria-controls="accordion-flush-body-6">
                            <div class="text-left">
                                <p class="text-xl text-gray-500 font-semibold">
                                    Memorised Proficiency</p>
                                <p class="text-sm text-[#219EBC] font-bold">TOEIC
                                    score
                                    range of 185 - 250</p>
                            </div>
                            <svg data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-6" class="hidden" aria-labelledby="accordion-flush-heading-6">
                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                            <p class="mb-2 text-gray-500 dark:text-gray-400">This range of values indicates that
                                individuals have very limited ability in English. They may only be able to remember and
                                repeat information that is already known with very limited. They can understand a few
                                simple
                                sentences and may communicate in very limited contexts, but their English language
                                skills
                                are significantly limited.</p>
                        </div>
                    </div>

                    <!-- No Useful Proficiency -->
                    <h2 id="accordion-flush-heading-7">
                        <button type="button"
                            class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-7" aria-expanded="false"
                            aria-controls="accordion-flush-body-7">
                            <div class="text-left">
                                <p class="text-xl text-gray-500 font-semibold">
                                    No Useful Proficiency</p>
                                <p class="text-sm text-[#219EBC] font-bold">TOEIC
                                    score
                                    range of 10 - 180</p>
                            </div>
                            <svg data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0 transition-transform duration-300"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-7" class="hidden" aria-labelledby="accordion-flush-heading-7">
                        <div class="py-5">
                            <p class="mb-2 text-gray-500 dark:text-gray-400">This range of values indicates that
                                individuals do not have a useful ability in English for practical purposes. They may not
                                be
                                able to understand or communicate in English in a useful context. People with values
                                here
                                may have only basic knowledge or no knowledge of English at all.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- javascript for persentase --}}
    <script>
        function updateProgressBar(score, maxScore, progressBarId, scoreId) {
            const percentage = (score / maxScore) * 100;
            document.getElementById(progressBarId).style.width = percentage + '%';
            document.getElementById(scoreId).innerText = score;
        }

        // Update progress bar reading
        const score1 = {{ $skorReading }};
        const maxScore1 = 495;
        updateProgressBar(score1, maxScore1, 'progress-bar-1', 'score-1');

        // Update progress bar listening
        const score2 = {{ $skorListening }};
        const maxScore2 = 495;
        updateProgressBar(score2, maxScore2, 'progress-bar-2', 'score-2');
    </script>

    {{-- matiin fungsi back browser --}}
    <script>
        history.replaceState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.replaceState(null, null, document.URL);
        });
    </script>

</body>

</html>
