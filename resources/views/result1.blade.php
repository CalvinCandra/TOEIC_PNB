<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>Result</title>
    <style>
        
        .container {
            margin-left: 100px;
            display: flex;
            gap: 20px; /* space between cards */
            
        }
        .containers {
            margin-top: 20px;
            margin-left: 100px;
            display: flex;
            gap: 20px; /* space between cards */
        }
        .containerse {
            display: flex;
            gap: 20px; /* space between cards */
        }
        .card {
            padding: 80px;
            background-color: #ffffff; /* white */
            border: 1px solid #e5e7eb; /* border-gray-200 */
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-color: #7e7e7e;
            border-width: 2px;
        }
        
        
        .card h5 {
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937; /* text-gray-900 */
        }
        .card p {
            font-weight: bold;
            font-size: 40pt;
            color: #000000; /* text-gray-700 */
            text-align: center; /* Center text */
        }


        .card1 {
            
        }


        
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Add Flowbite CSS -->
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />
</head>
<body>
    <div class= "fonts" style="margin-top: 20px; margin-bottom: 20px; margin-left: 100px" >
        <p class="user" style="font-size: 15pt; ">Hi, Username</p>
        <p class="user" style="font-size: 20pt; font-weight: bold">Here's a simulation of the toeic test you did.</p>
        <p class="user" style="font-size: 10pt; ">See the scores and results you've obtained in Starting TOEIC test</p>
        <p class="user" style="font-size: 10pt; padding-top: 20px; font-weight: bold; color: #b1b1b1;"><i>*Hasil Test bukan merupakan sertifikat*</i></p>
    </div>

    <!-- pertama -->
    <div class="container">
        <div class="card">
            <h5 class="mb-2 text-2xl font-bold tracking-tight">TOTAL SCORE</h5>
            <p class="font-normal">975</p>
        </div>

        <div class="card1" style="width: 800px; border-radius: 10px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 20px; ">
            <div class="w-1/2 pl-4">
                <div class="mb-2">
                    <div class="flex justify-between">
                        <span class="font-bold" style="background-color: #FFB703"> LISTENING </span>
                    </div>
                    <div class="container2" style="display: flex; width: 700px;">
                        <div class="bg-gray-200 h-2  mt-1" style="margin-top: 40px; width: 700px; height: 20px;">
                        <div class="blues h-2 " style="width: 70%; height: 20px; background-color: #219EBC"></div>
                    </div>
                    <span class="font-bold" style="margin-left: 20px; margin-top: 35px">480</span>
                </div>  
                </div>  
            </div>
            <div class="w-1/2 pl-4" style="margin-top: 40px">
                <div class="mb-2">
                    <div class="flex justify-between">
                        <span class="font-bold" style="background-color: #FFB703"> READING </span>
                    </div>
                    <div class="container2" style="display: flex; width: 700px;">
                        <div class="bg-gray-200 h-2  mt-1" style="margin-top: 40px; width: 700px; height: 20px;">
                        <div class="blues h-2 " style="width: 70%; height: 20px; background-color: #219EBC"></div>
                    </div>
                    <span class="font-bold" style="margin-left: 20px; margin-top: 35px">480</span>
                </div>  
                </div>  
            </div>
        </div>
        </div>
    </div>

    <!-- kedua -->
    <div class="containers">
        <div class="cards">
            <p class="font-normal" style="margin-right: 228px; font-weight: bold">Your Result</p>
            <div class="line1" style="width: 300px; height: 60px; margin-top: 10px; margin-bottom: 150px; background-color: #bbdae8; border-radius: 10px">
                <p class="user" style="font-size: 16pt; font-weight: bold; padding-left: 25px; padding-top: 12px; color: #6CB8DC ">International Proficiency</p>
                <div class="containerse">
                    <img src="{{asset('sendmail/SendEmail.png')}}" alt="SendEmail" style="size: 50px; margin-top: 50px ">
                    <div class="mail">
                        <p class="font-normal" style=" margin-top: 50px">Your results have been sent to</p>
                        <p class="font-normal" style=" font-weight: bold">example@gmail.com</p>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="card1" style="width: 800px; border-radius: 10px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 20px; ">
            <p class="user" style="font-size: 20pt; font-weight: bold; ">An explanation of your nature</p>
            <p class="user" style="font-size: 15pt; font-weight: bold; color: rgb(119, 119, 119) ">International Proficiency</p>
            <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC">TOEIC score range of 905 - 990</p>
            <div class="line1" style="width: 750px; height: 2px; margin-top: 10px; margin-bottom: 150px; background-color: rgb(0, 0, 0)"></div>
        </div>
    </div>

       <!-- ketiga -->
<div class="containers">
    <div class="card1" style="margin-left: 333px; margin-bottom: 30px; width: 800px; border-radius: 10px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 20px;">
        <p class="user" style="font-size: 20pt; font-weight: bold;">KATEGORI HASIL LAINNYA</p>

        <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
            
            <!-- Accordion 1 -->
            <h2 id="accordion-flush-heading-1">
                <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-1" aria-expanded="false" aria-controls="accordion-flush-body-1">
                    <div class="s" style="text-align: left;">
                        <p class="user" style="font-size: 16pt; color: rgb(119, 119, 119); margin-bottom: 20px">International Proficiency</p>
                        <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC;">TOEIC score range of 905 - 990</p>
                    </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
                    <p class="text-gray-500 dark:text-gray-400">Check out this guide to learn how to <a href="/docs/getting-started/introduction/" class="text-blue-600 dark:text-blue-500 hover:underline">get started</a> and start developing websites even faster with components on top of Tailwind CSS.</p>
                </div>
            </div>
            
            <!-- Accordion 2 -->
            <h2 id="accordion-flush-heading-2">
                <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                    <div class="s" style="text-align: left;">
                        <p class="user" style="font-size: 16pt; color: rgb(119, 119, 119); margin-bottom: 20px">Working Proficiency Plus</p>
                        <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC;">TOEIC score range of 785 - 900</p>
                    </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">This section includes advanced resources and guides to help you further your proficiency in various domains.</p>
                </div>
            </div>
            
            <!-- Accordion 3 -->
            <h2 id="accordion-flush-heading-3">
                <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                    <div class="s" style="text-align: left;">
                        <p class="user" style="font-size: 16pt; color: rgb(119, 119, 119); margin-bottom: 20px">Limited Working Proficiency</p>
                        <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC;">TOEIC score range of 605 - 780</p>
                    </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">Explore resources designed for upper intermediate learners aiming to enhance their skills.</p>
                </div>
            </div>
            
            <!-- Accordion 4 -->
            <h2 id="accordion-flush-heading-4">
                <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-4" aria-expanded="false" aria-controls="accordion-flush-body-4">
                    <div class="s" style="text-align: left;">
                        <p class="user" style="font-size: 16pt; color: rgb(119, 119, 119); margin-bottom: 20px">Elementary Proficiency Plus</p>
                        <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC;">TOEIC score range of 405 - 600</p>
                    </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-4" class="hidden" aria-labelledby="accordion-flush-heading-4">
                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">Intermediate learners can find materials here to build upon their existing knowledge.</p>
                </div>
            </div>
            
            <!-- Accordion 5 -->
            <h2 id="accordion-flush-heading-5">
                <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-5" aria-expanded="false" aria-controls="accordion-flush-body-5">
                    <div class="s" style="text-align: left;">
                        <p class="user" style="font-size: 16pt; color: rgb(119, 119, 119); margin-bottom: 20px">Elementary Proficiency</p>
                        <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC;">TOEIC score range of 255 - 400</p>
                    </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-5" class="hidden" aria-labelledby="accordion-flush-heading-5">
                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">Resources for elementary proficiency learners aiming to strengthen their foundational skills.</p>
                </div>
            </div>
            
            <!-- Accordion 6 -->
            <h2 id="accordion-flush-heading-6">
                <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-6" aria-expanded="false" aria-controls="accordion-flush-body-6">
                    <div class="s" style="text-align: left;">
                        <p class="user" style="font-size: 16pt; color: rgb(119, 119, 119); margin-bottom: 20px">Memorised Proficiency</p>
                        <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC;">TOEIC score range of 120 - 250</p>
                    </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-6" class="hidden" aria-labelledby="accordion-flush-heading-6">
                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">Introductory resources for those at the basic proficiency level.</p>
                </div>
            </div>
            
            <!-- Accordion 7 -->
            <h2 id="accordion-flush-heading-7">
                <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-7" aria-expanded="false" aria-controls="accordion-flush-body-7">
                    <div class="s" style="text-align: left;">
                        <p class="user" style="font-size: 16pt; color: rgb(119, 119, 119); margin-bottom: 20px">No Useful Proficiency</p>
                        <p class="user" style="font-size: 10pt; font-weight: bold; color: #219EBC;">TOEIC score range below 120</p>
                    </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-7" class="hidden" aria-labelledby="accordion-flush-heading-7">
                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">Materials designed specifically for beginners to start their learning journey.</p>
                </div>
            </div>

        </div>
        
    </div>
</div>


    

    
    
    @include('sweetalert::alert')
</body>
</html>
