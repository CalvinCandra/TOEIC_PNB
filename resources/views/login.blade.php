<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>Login</title>
</head>
<body style="background-color: #F1F1F1" class="font-Poppins">

    <div class="h-screen px-6 py-32 mx-auto w-4/5 ">
        <div class="flex bg-white rounded-md shadow-md">
            
            <div class="hidden w-2/5 lg:flex justify-center items-center mx-10">
                <img src="{{asset('auth/login.png')}}" alt="Gambar Login" class="w-full">
            </div>
    
            <div class="w-full flex flex-col lg:w-3/5 mx-5 my-5">
                @if ($message = Session::get('gagal'))
                    <div id="alert-2" class="flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <div class="ml-3 text-sm font-medium">
                            {{ $message }}
                        </div>
                    </div>
                @endif
                <h1 class="pb-8 text-2xl font-extrabold">Login</h1>
                <h5 class="mb-2">Enter your email to log in</h5>

                <form action="{{url('/ProsesLogin')}}" method="post" class="flex flex-col w-full h-44 justify-between">
                    @csrf
                    <input type="email" name="email" id="" class="rounded-2xl bg-slate-50 p-2" placeholder="Enter Your Email">
                    @error('email')
                        <div class="mb-3 text-sm italic text-red-400">
                            {{$message}}
                        </div>
                    @enderror

                    <input type="password" name="password" id="" class="rounded-2xl p-2" placeholder="Enter Your Password">
                    @error('password')
                        <div class="mb-3 text-sm italic text-red-400">
                            {{$message}}
                        </div>
                    @enderror
    
                    <button type="submit" class="bg-sky-500 rounded-2xl py-2 text-white font-semibold hover:bg-sky-600">Continue</button>
                </form>
    
                <p class="my-8 text-center">Don't have an account yet? <a href="#" class="underline text-sky-400 hover:text-sky-600">Register</a></p>

                <div class="relative border-t-2 flex justify-center">
                    <p class="bg-white h-7 w-9 flex justify-center items-center text-center absolute -top-3.5 text-slate-400">OR</p>
                </div>

                <p class="my-8 text-center">By continuing, you agree to the updated <span class="font-semibold">Terms of Sale, Terms of Service</span>, and <span class="font-semibold">Privacy Policy.</span></p>
                
            </div>
        </div>
    </div>

    
</body>
</html>