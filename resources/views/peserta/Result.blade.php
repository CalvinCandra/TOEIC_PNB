<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')


    <title>Nilai</title>

    {{-- disable back button --}}
    <script type="text/javascript">
        window.history.forward(1);
    </script>
</head>
<body>
    <h1 class="mb-10 text-xl">Nilai</h1>


    <h1>Benar Reading : {{$Readingbenar}}</h1>
    <h1>Salah Reading : {{$Readingsalah}}</h1>

    <h1>Benar Listening : {{$Listeningbenar}}</h1>
    <h1>Salah Listening : {{$Listeningsalah}}</h1>

    <h1>Total Benar : {{$Readingbenar + $Listeningbenar}}</h1>
    <h1 class="mb-10">Total Salah : {{$Readingsalah + $Listeningsalah}}</h1>

    <a href="{{url('/destory')}}" class="mt-10 text-blue-500">Back</a>

    {{-- matiin fungsi back browser --}}
    <script>
        history.replaceState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.replaceState(null, null, document.URL);
        });
    </script>
    
</body>
</html>