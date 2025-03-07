<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>Login</title>
</head>
<body style="background-color: #F1F1F1; font-family: 'Poppins'">

    {{-- Animation Loading --}}
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 items-center justify-center z-[999] hidden" id="overlay">
        <div class="text-center">
            <div role="status">
                <svg aria-hidden="true" class="inline w-10 h-10 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    
    {{-- kontent --}}
    <div class="h-screen px-3 lg:px-6 lg:w-4/5 w-full flex items-center justify-center lg:mx-auto">
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

                    <div class="relative">
                        <input type="password" name="password" id="inputPassword" class="block w-full rounded-lg bg-[#F3F4F6] pl-3 mt-5 border-none focus:ring-2 placeholder:italic" placeholder="Your Password">
                        <span class="absolute end-2.5 bottom-[8px] cursor-pointer icon"><i class="fa-regular fa-eye-slash"></i></span>
                    </div>
                    @error('password')
                        <div class=" mt-1 text-sm italic text-red-400">
                            {{$message}}
                        </div>
                    @enderror
    
                    <button type="submit" class="bg-sky-500 rounded-full my-5 py-2 text-white font-semibold hover:bg-sky-600">Continue</button>
                </form>

                <p class="text-center lg:text-base text-sm">By continuing, you agree to the updated <span class="font-semibold">Terms of Sale, Terms of Service</span>, and <span class="font-semibold">Privacy Policy.</span></p>
                
            </div>
        </div>
    </div>

    
    @include('sweetalert::alert')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.modal-form');
            const overlay = document.getElementById('overlay');
    
            // Menampilkan overlay saat pengguna meninggalkan halaman
            window.addEventListener('beforeunload', function(event) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            });
    
            // Menyembunyikan overlay setelah halaman sepenuhnya dimuat
            window.addEventListener('load', function(event) {
                overlay.classList.remove('flex');
                overlay.classList.add('hidden');
            });
        });
    </script>

    {{-- show password --}}
    <script>
        const passwordField = document.getElementById("inputPassword");
        const togglePassword = document.querySelector(".icon i");

        togglePassword.addEventListener("click", function () {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            togglePassword.classList.remove("fa-eye-slash");
            togglePassword.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            togglePassword.classList.remove("fa-eye");
            togglePassword.classList.add("fa-eye-slash");
        }
        });
    </script>
</body>
</html>