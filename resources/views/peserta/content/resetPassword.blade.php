<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password — TOEIC Assessment PNB</title>
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Inter', 'Poppins', sans-serif; }
        .input-field {
            width: 100%; height: 46px; padding: 0 48px 0 16px;
            border-radius: 12px; border: 1px solid #e2e8f0;
            background: #f8fafc; color: #1e293b; font-size: 0.875rem;
            outline: none; transition: border-color .2s, box-shadow .2s, background .2s;
            font-family: inherit;
        }
        .input-field::placeholder { color: #cbd5e1; }
        .input-field:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.10); background: #fff; }
        .eye-btn {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; padding: 0;
            color: #94a3b8; line-height: 0; transition: color .2s;
        }
        .eye-btn:hover { color: #2563eb; }
        .btn-submit {
            width: 100%; height: 46px; border-radius: 12px; background: #2563eb;
            color: #fff; font-size: 0.875rem; font-weight: 600; letter-spacing: 0.02em;
            border: none; cursor: pointer; transition: background .2s, transform .1s, box-shadow .2s;
            font-family: inherit; box-shadow: 0 4px 14px rgba(37,99,235,0.22);
        }
        .btn-submit:hover  { background: #1d4ed8; box-shadow: 0 6px 18px rgba(37,99,235,0.30); }
        .btn-submit:active { transform: translateY(1px); }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center px-4 py-8">

    {{-- Loading Overlay --}}
    <div id="overlay" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.45);
        backdrop-filter:blur(4px); align-items:center; justify-content:center; z-index:999;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" style="animation:spin 1s linear infinite;">
            <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" opacity=".25"/>
            <path d="M4 12a8 8 0 018-8" stroke="white" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    {{-- Card --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/80 border border-slate-100 overflow-hidden">

        {{-- Accent bar --}}
        <div class="h-1 bg-gradient-to-r from-blue-900 via-blue-600 to-blue-400"></div>

        <div class="px-8 py-10 sm:px-10">

            {{-- Icon + Heading (centered) --}}
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-1">Account Security</p>
                <h1 class="text-2xl font-extrabold text-slate-900">Change Password</h1>
                <p class="text-sm text-slate-400 mt-1">Keep your account secure with a strong password.</p>
            </div>

            {{-- Divider --}}
            <div class="h-px bg-slate-100 mb-7"></div>

            {{-- Form --}}
            <form action="{{ url('/reset-password') }}" method="POST" class="flex flex-col gap-5">
                @csrf

                {{-- Current Password --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5" for="password_old">
                        Current Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password_old" id="password_old"
                            placeholder="Enter your current password"
                            class="input-field" required />
                        <button type="button" class="eye-btn"
                            onclick="togglePw('password_old','eyeOld')" aria-label="Toggle">
                            <svg id="eyeOld" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_old')
                        <span class="text-xs text-red-500 mt-1 block">⚠ {{ $message }}</span>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5" for="password_new">
                        New Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password_new" id="password_new"
                            placeholder="Enter a new password"
                            class="input-field" required />
                        <button type="button" class="eye-btn"
                            onclick="togglePw('password_new','eyeNew')" aria-label="Toggle">
                            <svg id="eyeNew" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_new')
                        <span class="text-xs text-red-500 mt-1 block">⚠ {{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5" for="password_confirmation">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Re-enter your new password"
                            class="input-field" required />
                        <button type="button" class="eye-btn"
                            onclick="togglePw('password_confirmation','eyeConfirm')" aria-label="Toggle">
                            <svg id="eyeConfirm" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-submit mt-1">Update Password</button>

            </form>

        </div>
    </div>

    <script>
        const overlay  = document.getElementById('overlay');
        const openEye  = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        const closeEye = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';

        window.addEventListener('beforeunload', () => { overlay.style.display = 'flex'; });
        window.addEventListener('load',          () => { overlay.style.display = 'none'; });

        function togglePw(inputId, iconId) {
            const el  = document.getElementById(inputId);
            const ico = document.getElementById(iconId);
            el.type = el.type === 'password' ? 'text' : 'password';
            ico.innerHTML = el.type === 'text' ? openEye : closeEye;
        }
    </script>

</body>
</html>
