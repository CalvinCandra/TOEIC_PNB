<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>Login</title>
</head>
<body style="background-color: #F1F1F1; font-family: 'Poppins'">
    
    <div class="h-screen px-6 py-32 mx-auto w-4/5 ">
        <div class="flex bg-white rounded-md shadow-md">
            
            <div class="hidden w-2/5 lg:flex justify-center items-center mx-10">
                <img src="{{asset('auth/login.png')}}" alt="Gambar Login" class="w-full">
            </div>
    
            <div class="w-full flex flex-col lg:w-2/4 mx-5 my-5 lg:mt-14">

                <h1 class="pb-8 text-4xl mb-2 md:mb-0 mb:text-5xl font-extrabold text-center uppercase">Login</h1>

                <form action="{{url('/ProsesLogin')}}" method="post" class="flex flex-col w-full">
                    @csrf
                    <h5 class="mb-1">Enter your email to log in.</h5>
                    <input type="email" name="email" id="" class="rounded-lg bg-[#F3F4F6] pl-3 border-none focus:ring-2 placeholder:italic" placeholder="Your Email" value="{{old('email')}}">
                    @error('email')
                        <div class=" mt-1 text-sm italic text-red-400">
                            {{$message}}
                        </div>
                    @enderror

                    <input type="password" name="password" id="" class="rounded-lg bg-[#F3F4F6] pl-3 mt-5 border-none focus:ring-2 placeholder:italic" placeholder="Your Password">
                    @error('password')
                        <div class=" mt-1 text-sm italic text-red-400">
                            {{$message}}
                        </div>
                    @enderror
    
                    <button type="submit" class="bg-sky-500 rounded-full my-5 py-2 text-white font-semibold hover:bg-sky-600">Continue</button>
                </form>

                <p class="text-center">By continuing, you agree to the updated <span class="font-semibold">Terms of Sale, Terms of Service</span>, and <span class="font-semibold">Privacy Policy.</span></p>
                
            </div>
        </div>
    </div>

    
    @include('sweetalert::alert')
</body>
</html>