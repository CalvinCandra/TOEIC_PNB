<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    {{-- Animation Loading --}}
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 items-center justify-center z-[999] hidden" id="overlay">
        <div class="text-center">
            <div role="status">
                <svg aria-hidden="true"
                    class="inline w-10 h-10 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <div class="max-w-md w-full bg-white rounded-3xl shadow-lg border border-gray-100 p-8">

        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-slate-900">Change Password</h2>
            <p class="text-sm text-slate-500 mt-2">Please update your password for account security.</p>
        </div>

        <form action="{{ url('/reset-password') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Old Password --}}
            <div class="space-y-1">
                <label for="password_old" class="block pl-3 text-sm font-semibold text-slate-700">Old Password</label>
                <div class="relative">
                    <input type="password" name="password_old" id="password_old" placeholder="Enter your old password"
                        class="w-full h-12 pl-5 pr-14 rounded-full border border-slate-200 bg-white text-slate-900 text-base italic outline-none focus:border-blue-950 focus:ring-2 focus:ring-blue-950/20 font-[inherit]"
                        required />
                    <span onclick="togglePassword('password_old', 'eyeIconOld')"
                        class="absolute right-5 top-1/2 -translate-y-1/2 cursor-pointer text-slate-400 flex items-center">
                        <svg id="eyeIconOld" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                    </span>
                </div>

                @error('password_old')
                    <span class="text-red-500 text-xs pl-3">{{ $message }}</span>
                @enderror

            </div>

            {{-- New Password --}}
            <div class="space-y-1">
                <label for="password_new" class="block pl-3 text-sm font-semibold text-slate-700">New Password</label>
                <div class="relative">
                    <input type="password" name="password_new" id="password_new" placeholder="Enter your new password"
                        class="w-full h-12 pl-5 pr-14 rounded-full border border-slate-200 bg-white text-slate-900 text-base italic outline-none focus:border-blue-950 focus:ring-2 focus:ring-blue-950/20 font-[inherit]"
                        required />
                    <span onclick="togglePassword('password_new', 'eyeIconNew')"
                        class="absolute right-5 top-1/2 -translate-y-1/2 cursor-pointer text-slate-400 flex items-center">
                        <svg id="eyeIconNew" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                    </span>
                </div>
                @error('password_new')
                    <span class="text-red-500 text-xs pl-3">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div class="space-y-1">
                <label for="password_confirmation" class="block pl-3 text-sm font-semibold text-slate-700">Password
                    Confirmation</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirm your new password"
                        class="w-full h-12 pl-5 pr-14 rounded-full border border-slate-200 bg-white text-slate-900 text-base italic outline-none focus:border-blue-950 focus:ring-2 focus:ring-blue-950/20 font-[inherit]"
                        required />
                    <span onclick="togglePassword('password_confirmation', 'eyeIconConfirm')"
                        class="absolute right-5 top-1/2 -translate-y-1/2 cursor-pointer text-slate-400 flex items-center">
                        <svg id="eyeIconConfirm" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                    </span>
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <button type="submit"
                    class="w-full h-12 rounded-full bg-blue-950 hover:bg-blue-900 text-white text-base font-normal tracking-wide transition-colors duration-150 font-[inherit]">
                    Update Your Password
                </button>
            </div>
        </form>

    </div>

    {{-- Script for Toggle Password --}}
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            // Icon Mata Terbuka
            const openEyePath =
                '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';

            // Icon Mata Tertutup (Tercoret)
            const closedEyePath =
                '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = openEyePath; // Ubah ke mata terbuka
            } else {
                input.type = 'password';
                icon.innerHTML = closedEyePath; // Kembalikan ke mata tertutup
            }
        }
    </script>
</body>

</html>
