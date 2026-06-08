<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-100/40 blur-3xl mix-blend-multiply pointer-events-none"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-indigo-100/40 blur-3xl mix-blend-multiply pointer-events-none"></div>

    <div class="max-w-md w-full text-center relative z-10">
        <div class="mb-6 flex justify-center">
            <span class="px-4 py-1.5 rounded-full bg-blue-100/80 text-blue-700 text-sm font-bold tracking-widest uppercase border border-blue-200/50 shadow-sm">Page Not Found</span>
        </div>
        <div class="relative flex justify-center items-center">
            <h1 class="text-[12rem] leading-none font-black text-slate-800 tracking-tighter select-none drop-shadow-xl">404</h1>
        </div>
        <div class="mt-4">
            <h2 class="text-3xl font-bold text-slate-800 mb-4 tracking-tight">Oops! You seem lost.</h2>
            <p class="text-slate-500 mb-10 leading-relaxed text-lg">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            <div class="flex flex-col gap-4 items-center">
                <button onclick="window.history.back()" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all duration-200 hover:-translate-y-1 active:scale-95 focus:outline-none focus:ring-4 focus:ring-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Go Back
                </button>
                <a href="{{ url('/') }}" class="text-slate-500 hover:text-slate-800 font-medium transition-colors mt-2">
                    Or return to Homepage
                </a>
            </div>
        </div>
    </div>
</body>
</html>
