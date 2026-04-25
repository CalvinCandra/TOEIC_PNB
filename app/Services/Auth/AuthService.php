<?php

namespace App\Services\Auth;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function attempt(Request $request): ?string
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $loginInput  = $request->username;
        $credentials = ['password' => $request->password];

        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $loginInput;
        } else {
            $peserta = Peserta::where('nim', $loginInput)->first();

            if (! $peserta) {
                Log::warning('[AuthService] Login gagal - NIM tidak ditemukan', [
                    'nim' => $loginInput,
                    'ip'  => $request->ip(),
                ]);

                return null;
            }

            $credentials['id'] = $peserta->id_users;
        }

        Log::info('[AuthService] Percobaan login', [
            'input' => $loginInput,
            'ip'    => $request->ip(),
        ]);

        if (! Auth::attempt($credentials)) {
            Log::warning('[AuthService] Login gagal - kredensial salah', [
                'input' => $loginInput,
                'ip'    => $request->ip(),
            ]);

            return null;
        }

        $request->session()->regenerate();

        $user = auth()->user();

        Log::info('[AuthService] Login berhasil', [
            'input' => $loginInput,
            'level' => $user->level,
            'ip'    => $request->ip(),
        ]);

        return $user->level;
    }

    public function logout(Request $request): void
    {
        $user = auth()->user();

        Log::info('[AuthService] User logout', [
            'email' => $user?->email,
            'level' => $user?->level,
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}