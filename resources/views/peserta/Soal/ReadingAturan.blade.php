<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <!-- CDN Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- favicon --}}
    <link rel="shortcut icon" href="{{asset('img/logo unit.png')}}" type="image/x-icon">

    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Anti-Back Browser -->
    <script>
        (function () {
            history.pushState(null, '', location.href);
            history.pushState(null, '', location.href);

            window.addEventListener('popstate', function () {
                history.pushState(null, '', location.href);
                history.pushState(null, '', location.href);
            });

            document.addEventListener('keydown', function (e) {
                if ((e.altKey && e.key === 'ArrowLeft') || e.key === 'BrowserBack') {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        })();
    </script>

    <title>Reading - Rules & Directions</title>
</head>

<body style="font-family: 'Poppins'" class="bg-[#f1f5f9] h-screen overflow-hidden flex flex-col relative">

    {{-- Top Navbar --}}
    <header class="bg-white border-b border-gray-200 hidden md:block px-6 py-3 sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('img/logo unit.png')}}" alt="Logo PNB" class="h-9">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-bold text-slate-800 tracking-wide">TOEIC Assessment</span>
                    <span class="text-[11px] text-slate-500">Politeknik Negeri Bali</span>
                </div>
            </div>
            <div class="flex gap-2">
                <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-book-open"></i> Reading Section
                </span>
            </div>
        </nav>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 min-h-0 max-w-5xl mx-auto w-full p-4 md:py-6 md:px-8 flex flex-col">
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 flex flex-col flex-1 min-h-0 overflow-hidden">
            
            {{-- Header --}}
            <div class="bg-slate-50 border-b border-slate-100 p-5 md:p-6 flex items-center gap-4 shrink-0">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-lg md:text-xl shadow-inner">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-xl md:text-2xl text-slate-800">Reading Test - Direction</h1>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Please read the following instructions carefully before proceeding.</p>
                </div>
            </div>

            {{-- Rules List --}}
            <div class="p-5 md:p-8 bg-white flex-1 overflow-y-auto custom-scrollbar"> 
                <ol class="space-y-4 md:space-y-5 text-slate-600 list-decimal list-outside ml-5 text-[13px] md:text-[14px] leading-relaxed text-justify marker:font-bold marker:text-blue-500">
                    <li>
                        <span class="font-bold text-slate-800">No Cheating:</span> Any form of cheating, such as attempting to with other test takers, using unauthorized materials, or copying answers, will result in immediate disqualification.
                    </li>
                    <li>
                        <span class="font-bold text-slate-800">Follow Instructions:</span> Test takers must carefully listen to and follow all instructions provided by the test administrator. Failure to do so may result in penalties or disqualification.
                    </li>
                    <li>
                        <span class="font-bold text-slate-800">No Writing During Reading:</span> Writing or marking on any materials during the Reading section is strictly prohibited as the time is also limited. Answers should be recorded only during designated answer periods.
                    </li>
                    <li>
                        <span class="font-bold text-slate-800">Total Reading Questions:</span> On the Reading test, there are 100 questions that you must answer. The question type is multiple choice.
                    </li>
                    <li>
                        <span class="font-bold text-slate-800">Total Times Reading:</span> In the Reading test, the total time given to complete this test is 75 minutes.
                    </li>
                    <li>
                        <span class="font-bold text-slate-800">Complete the Test Independently:</span> Each test taker is expected to complete the test independently. Collaboration or sharing of answers is not permitted.
                    </li>
                    <li>
                        <span class="font-bold text-slate-800">Stay until the End:</span> Test takers must remain seated until the completion of the entire test.
                    </li>
                    <li>
                        <span class="font-bold text-slate-800">No Test Retake:</span> The test can ONLY be done once and there will be no chance to resit the test. Failure to maintain good internet connection or time management will not be tolerated.
                    </li>
                </ol>
            </div>

            {{-- Footer Action --}}
            <div class="bg-slate-50 border-t border-slate-100 p-5 md:p-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4 shrink-0">
                <div class="flex items-center gap-3 text-amber-700 bg-amber-50 px-4 py-3 rounded-xl border border-amber-100 flex-1 md:max-w-md">
                    <i class="fa-solid fa-clock text-amber-500 text-lg"></i>
                    <p class="text-xs font-medium leading-relaxed"><span class="font-bold">Important Note:</span> The countdown timer starts immediately.</p>
                </div>
                
                <button id="startQuizButton" type="button" class="flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm px-8 py-3.5 transition-all duration-300 shadow-sm hover:shadow-lg hover:shadow-blue-600/20 active:scale-95 w-full md:w-auto">
                    Start Reading Test <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

    </main>
    
    {{-- Script Start Reading Test --}}
    <script>
        document.getElementById("startQuizButton").addEventListener("click", function () {
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-lg"></i> Preparing test...';
            this.disabled = true;
            this.classList.add('opacity-80', 'cursor-not-allowed');

            if (typeof window.x !== 'undefined') {
                clearInterval(window.x);
            }

            localStorage.removeItem('quizStartTime');

            window.location.replace("{{ url('/SoalReading') }}");
        });
    </script>

</body>
</html>
