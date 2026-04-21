<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>Sign In — TOEIC Assessment PNB</title>
    <meta name="description" content="Sign in to TOEIC Assessment Politeknik Negeri Bali.">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            margin: 0; padding: 0;
            background-color: #f1f5f9; /* slate-100 */
            min-height: 100vh;
        }

        /* ── Page wrapper ── */
        .page-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        /* ── Card ── */
        .card {
            width: 100%;
            max-width: 900px;
            display: flex;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(15,30,60,0.10), 0 1px 4px rgba(15,30,60,0.06);
            border: 1px solid #e2e8f0;
        }

        /* ── Left panel (desktop only) ── */
        .panel-left {
            display: none;
            flex: 0 0 42%;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 28px;
            padding: 52px 40px;
            background: linear-gradient(150deg, #0f1e3c 0%, #1e3a6e 100%);
        }
        @media (min-width: 1024px) {
            .panel-left { display: flex; }
        }
        .panel-left img   { width: 180px; object-fit: contain; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.3)); }
        .panel-left h2    { font-size: 0.75rem; font-weight: 700; color: #fff; letter-spacing: 0.15em; text-transform: uppercase; text-align: center; margin: 0; }
        .panel-left p     { font-size: 0.72rem; color: rgba(186,220,255,0.80); margin: 4px 0 0; text-align: center; }
        .panel-left hr    { border: none; height: 1px; width: 36px; background: rgba(147,197,253,0.25); margin: 0; }
        .panel-left small { font-size: 0.72rem; color: rgba(186,220,255,0.65); text-align: center; line-height: 1.7; max-width: 210px; }

        /* ── Right panel (form) ── */
        .panel-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 36px;
        }
        @media (min-width: 640px) {
            .panel-right { padding: 52px 52px; }
        }

        /* ── Mobile brand header ── */
        .mobile-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 10px;
            margin-bottom: 28px;
            padding-bottom: 22px;
            border-bottom: 1px solid #e2e8f0;
        }
        .mobile-brand img   { width: 110px; object-fit: contain; }
        .mobile-brand h2    { font-size: 0.72rem; font-weight: 700; color: #1e3a6e; letter-spacing: 0.12em; text-transform: uppercase; margin: 0; }
        .mobile-brand p     { font-size: 0.68rem; color: #94a3b8; margin: 2px 0 0; }
        @media (min-width: 1024px) { .mobile-brand { display: none; } }

        /* ── Heading ── */
        .form-label-brand { font-size: 0.68rem; font-weight: 700; color: #2563eb; letter-spacing: 0.12em; text-transform: uppercase; }
        .form-title        { font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 6px 0 4px; line-height: 1.2; }
        .form-subtitle     { font-size: 0.82rem; color: #94a3b8; margin: 0 0 28px; }

        /* ── Field label ── */
        .field-label { display: block; font-size: 0.72rem; font-weight: 500; color: #64748b; margin-bottom: 6px; }

        /* ── Input ── */
        .input-field {
            width: 100%;
            height: 46px;
            padding: 0 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #1e293b;
            font-size: 0.875rem;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
            font-family: inherit;
        }
        .input-field::placeholder { color: #cbd5e1; }
        .input-field:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
            background: #fff;
        }
        .input-wrap { position: relative; }
        .eye-btn {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; padding: 0;
            color: #94a3b8; line-height: 0; transition: color .2s;
        }
        .eye-btn:hover { color: #2563eb; }

        /* ── Button ── */
        .btn-submit {
            width: 100%;
            height: 46px;
            border-radius: 12px;
            background: #2563eb;
            color: #fff;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .1s, box-shadow .2s;
            font-family: inherit;
            box-shadow: 0 4px 14px rgba(37,99,235,0.22);
            margin-top: 8px;
        }
        .btn-submit:hover  { background: #1d4ed8; box-shadow: 0 6px 18px rgba(37,99,235,0.30); }
        .btn-submit:active { transform: translateY(1px); }

        /* ── Error alert ── */
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 10px 14px; margin-bottom: 18px; }
        .alert-error p { font-size: 0.8rem; color: #dc2626; margin: 0; }
    </style>
</head>

<body>

    {{-- Loading Overlay --}}
    <div style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);
                align-items:center;justify-content:center;z-index:999;" id="overlay">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" style="animation:spin 1s linear infinite;">
            <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" opacity=".25"/>
            <path d="M4 12a8 8 0 018-8" stroke="white" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>
    <style>@keyframes spin{to{transform:rotate(360deg)}}</style>

    <div class="page-wrap">
        <div class="card">

            {{-- Left panel --}}
            <div class="panel-left">
                <img src="{{ asset('auth/login.png') }}" alt="TOEIC PNB" />
                <div style="text-align:center;">
                    <h2>Politeknik Negeri Bali</h2>
                    <p>Unit Penunjang Akademik Bahasa</p>
                </div>
                <hr />
                <small>TOEIC Assessment — Practice and improve your English proficiency score anytime, anywhere.</small>
            </div>

            {{-- Right panel --}}
            <div class="panel-right">

                {{-- Mobile brand header --}}
                <div class="mobile-brand">
                    <img src="{{ asset('auth/login.png') }}" alt="TOEIC PNB" />
                    <div>
                        <h2>Politeknik Negeri Bali</h2>
                        <p>Unit Penunjang Akademik Bahasa</p>
                    </div>
                </div>

                {{-- Heading --}}
                <p class="form-label-brand">TOEIC Assessment</p>
                <h1 class="form-title">Sign In</h1>
                <p class="form-subtitle">Enter your email or Student ID to continue.</p>

                {{-- Error --}}
                @if (count($errors) > 0)
                    <div class="alert-error">
                        @foreach ($errors->all() as $error)
                            <p>⚠ {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Form --}}
                <form action="{{ url('/ProsesLogin') }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
                    @csrf

                    <div>
                        <label class="field-label" for="username">Email or Student ID (NIM)</label>
                        <input type="text" name="username" id="username"
                            placeholder="e.g. student@pnb.ac.id or 2215313xxx"
                            value="{{ old('username') }}"
                            class="input-field" />
                    </div>

                    <div>
                        <label class="field-label" for="inputPassword">Password</label>
                        <div class="input-wrap">
                            <input type="password" name="password" id="inputPassword"
                                placeholder="Your password"
                                class="input-field" style="padding-right:48px;" />
                            <button type="button" class="eye-btn" onclick="togglePassword()" aria-label="Toggle password">
                                <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Sign In</button>
                </form>

            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <script>
        const overlay = document.getElementById('overlay');
        window.addEventListener('beforeunload', () => { overlay.style.display = 'flex'; });
        window.addEventListener('load',          () => { overlay.style.display = 'none'; });

        function togglePassword() {
            const pw  = document.getElementById('inputPassword');
            const ico = document.getElementById('eyeIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                ico.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            } else {
                pw.type = 'password';
                ico.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            }
        }
    </script>

</body>
</html>
