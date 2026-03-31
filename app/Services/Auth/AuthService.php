<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function attempt(Request $request): ?string
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('[AuthService::attempt] Percobaan login', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $level = auth()->user()->level;

            Log::info('[AuthService::attempt] Login berhasil', [
                'email' => $request->email,
                'level' => $level,
                'ip' => $request->ip(),
            ]);

            return $level;
        }

        Log::warning('[AuthService::attempt] Login gagal - kredensial salah', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        return null;
    }

    public function logout(Request $request): void
    {
        Log::info('[AuthService::logout] User logout', [
            'email' => auth()->user()?->email,
            'level' => auth()->user()?->level,
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
