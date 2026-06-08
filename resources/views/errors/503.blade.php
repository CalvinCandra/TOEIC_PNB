<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Under Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-[10%] left-[20%] w-[40%] h-[40%] rounded-full bg-amber-100/40 blur-3xl mix-blend-multiply pointer-events-none"></div>
    <div class="absolute bottom-[10%] right-[20%] w-[40%] h-[40%] rounded-full bg-yellow-100/40 blur-3xl mix-blend-multiply pointer-events-none"></div>

    <div class="max-w-lg w-full text-center relative z-10">
        <div class="relative mb-12 flex justify-center">
            <div class="w-40 h-40 bg-gradient-to-br from-amber-100 to-amber-50 rounded-full flex items-center justify-center shadow-inner relative overflow-visible border border-amber-200/50">
                <!-- Floating Elements -->
                <div class="absolute -right-6 -top-2 w-16 h-16 bg-amber-200/40 rounded-full blur-sm"></div>
                <div class="absolute -left-4 -bottom-4 w-20 h-20 bg-amber-300/20 rounded-full blur-md"></div>
                
                <!-- Icon -->
                <svg class="w-20 h-20 text-amber-500 relative z-10 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
        <div>
            <h2 class="text-4xl font-black text-slate-800 mb-5 tracking-tight">Under Maintenance</h2>
            <p class="text-slate-500 mb-10 leading-relaxed text-lg">We are currently performing some scheduled maintenance to improve the system. We'll be back up and running shortly. Thank you for your patience!</p>
            <button onclick="window.location.reload()" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-semibold rounded-xl text-white bg-amber-500 hover:bg-amber-600 shadow-lg shadow-amber-500/30 transition-all duration-200 hover:-translate-y-1 active:scale-95 focus:outline-none focus:ring-4 focus:ring-amber-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Check Status
            </button>
        </div>
    </div>
</body>
</html>
