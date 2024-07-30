<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN Tailwind -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite('resources/css/app.css')

    <!-- CDN Fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- favicon --}}
    <link rel="shortcut icon" href="{{asset('img/logo unit.png')}}" type="image/x-icon">

    {{-- goole font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script type="text/javascript">
        window.history.forward(1);
    </script>

    <title>Listening</title>
</head>

<body style="font-family: 'Poppins'" class="bg-gray-100">

    <header class="bg-white py-4 shadow w-full">
        <nav class="flex items-center justify-between px-10">
            <div class="flex justify-between items-center">
                <img src="{{asset('img/logo unit.png')}}" alt="Logo PNB" class="max-h-10 pe-2">
                <h1 class="font-bold text-xl">TOEIC</h1>
            </div>
        </nav>
    </header>

    <div class="h-full flex justify-center items-center">
        <div class="bg-white m-4 py-5 px-8 h-full w-full rounded-lg overflow-y-auto">
            <h1 class="font-bold text-xl">Listening Test - Direction</h1>

            <div class="bg-gray-100 h-[32rem] m-4 md:m-6 overflow-y-auto px-5 py-6"> 
                <ol class="space-y-5 text-black list-decimal list-inside text-justify">
                    <li>
                        <span class="font-bold">No Cheating:</span> Any form of cheating, such as attempting to with other test takers, using unauthorized materials, or copying answers, will result in immediate disqualification.
                    
                    </li>

                    <li>
                        <span class="font-bold">Follow Instructions:</span> Test takers must carefully listen to and follow all instructions provided by the test administrator. Failure to do so may result in penalties or disqualification.
                    
                    </li>

                    <li>
                        <span class="font-bold">Raise Hand for Assistance:</span> If a test taker requires assistance or encounters technical difficulties during the test, they should raise their hand and wait for a proctor to assist them.
                    
                    </li>
                    <li>
                        <span class="font-bold">No Writing During Listening:</span> Writing or marking on any materials during the listening section is strictly prohibited. Answers should be recorded only during designated answer periods.
                    </li>
                    <li>
                        <span class="font-bold">Total Question Listening:</span> On the listening test, there are 50 questions that you have to do. The question type is multiple choice.
                    </li>
                    <li>
                        <span class="font-bold">Total Times Listening:</span> in the listening test, the total time given to complete this test is 60 minutes.
                    </li>
                    <li>
                        <span class="font-bold">Complete the Test Independently:</span> Each test taker is expected to complete the test independently. Collaboration or sharing of answers is not permitted.
                    </li>
                    <li>
                        <span class="font-bold"> Stay until the End:</span> Test takers must remain seated until the completion of the entire test. Leaving the testing room before the test concludes is not allowed.
                    </li>
                </ol>
            </div>

            <div class="flex-warp md:flex md:justify-between md:items-center">
                <p class="my-4 md:my-0"><span class="font-bold">Note :</span> Timer start when you start the test</p>
                <button id="startQuizButton" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Start Test Listening</button>
            </div>
        </div>
    </div>

    {{-- matiin fungsi back pada browser --}}
    <script>
        history.replaceState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.replaceState(null, null, document.URL);
        });
    </script>

    {{-- redirect ke halaman Test --}}
    <script>
        // Fungsi untuk menangani quiz start
        function startQuiz() {
            // Simpan waktu mulai di localStorage
            localStorage.setItem("quizStartTime", Date.now().toString());

            // Hentikan countdown sebelumnya (jika ada)
            if (typeof window.x != 'undefined') {
                clearInterval(window.x);
            }

            // URL tujuan
            const targetUrl = "{{ url('/SoalListening') }}"; // Ubah URL sesuai dengan yang dibutuhkan

            // Arahkan browser ke URL tersebut
            window.location.href = targetUrl;
        }

        // Tambahkan event listener ke tombol dengan id "startQuizButton"
        document.getElementById("startQuizButton").addEventListener("click", startQuiz);
    </script>
    
</body>

</html>