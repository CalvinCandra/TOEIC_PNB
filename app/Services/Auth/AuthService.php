<?php

namespace App\Services\Auth;

use App\Models\Peserta; // Pastikan model Peserta di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function attempt(Request $request): ?string
    {
        // 1. Ubah validasi dari 'email' menjadi 'username' (bisa menerima email atau nim)
        $request->validate([
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        $loginInput = $request->username;
        $credentials = ['password' => $request->password];

        // 2. Cek apakah input berupa Email (Admin) atau NIM (Peserta)
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            // Jika formatnya email, gunakan kolom email untuk tabel users
            $credentials['email'] = $loginInput;
        } else {
            // Jika bukan email, asumsikan itu NIM. Cari relasi usernya di tabel peserta.
            $peserta = Peserta::where('nim', $loginInput)->first();

            if (! $peserta) {
                Log::warning('[AuthService::attempt] Login gagal - NIM tidak ditemukan', [
                    'nim' => $loginInput,
                    'ip' => $request->ip(),
                ]);
                return null;
            }

            // Jika NIM ketemu, gunakan id_users dari tabel peserta untuk login ke tabel users
            $credentials['id'] = $peserta->id_users;
        }

        Log::info('[AuthService::attempt] Percobaan login', [
            'input' => $loginInput,
            'ip' => $request->ip(),
        ]);

        // 3. Auth::attempt bisa menggunakan 'id' atau 'email'
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $level = auth()->user()->level;

            Log::info('[AuthService::attempt] Login berhasil', [
                'input' => $loginInput,
                'level' => $level,
                'ip' => $request->ip(),
            ]);

            return $level;
        }

        Log::warning('[AuthService::attempt] Login gagal - kredensial salah', [
            'input' => $loginInput,
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