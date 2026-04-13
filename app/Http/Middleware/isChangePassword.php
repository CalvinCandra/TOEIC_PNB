<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isChangePassword
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Menggunakan !$user->is_password_changed lebih ringkas daripada == false
        if ($user && $user->level === 'peserta' && !$user->is_password_changed) {
            
            // PENTING: Cegah Infinite Loop
            // Pastikan URL saat ini bukan '/reset-password' atau '/proses-ubah-password'
            if (!$request->is('reset-password') && !$request->is('proses-ubah-password*')) {
                return redirect('/reset-password')->with('info', 'Anda wajib mengubah password default sebelum melanjutkan.');
            }
        }

        return $next($request);
    }
}