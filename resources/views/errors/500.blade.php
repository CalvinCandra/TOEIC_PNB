<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-rose-100/40 blur-3xl mix-blend-multiply pointer-events-none"></div>
    <div class="absolute -bottom-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-orange-100/40 blur-3xl mix-blend-multiply pointer-events-none"></div>

    <div class="max-w-md w-full text-center relative z-10">
        <div class="mb-6 flex justify-center">
            <span class="px-4 py-1.5 rounded-full bg-rose-100/80 text-rose-700 text-sm font-bold tracking-widest uppercase border border-rose-200/50 shadow-sm">Server Error</span>
        </div>
        <div class="relative flex justify-center items-center">
            <h1 class="text-[12rem] leading-none font-black text-slate-800 tracking-tighter select-none drop-shadow-xl">500</h1>
        </div>
        <div class="mt-4">
            <h2 class="text-3xl font-bold text-slate-800 mb-4 tracking-tight">Oops! Something went wrong.</h2>
            <p class="text-slate-500 mb-10 leading-relaxed text-lg">Our servers encountered an unexpected issue. Don't worry, our technical team has been automatically notified. Please try again later.</p>
            <div class="flex flex-col gap-4 items-center">
                <button onclick="window.location.reload()" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-semibold rounded-xl text-white bg-rose-600 hover:bg-rose-700 shadow-lg shadow-rose-600/30 transition-all duration-200 hover:-translate-y-1 active:scale-95 focus:outline-none focus:ring-4 focus:ring-rose-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Page
                </button>
                <button onclick="window.history.back()" class="text-slate-500 hover:text-slate-800 font-medium transition-colors mt-2 cursor-pointer">
                    Or go back to previous page
                </button>
            </div>
        </div>
    </div>
</body>
</html>
