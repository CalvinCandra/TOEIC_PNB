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

        // Jika user belum ganti password default, paksa ke halaman reset
        // Kecuali jika sudah berada di halaman reset itu sendiri (cegah infinite loop)
        if (
            $user
            && $user->level === 'peserta'
            && ! $user->is_password_changed
            && ! $request->is('reset-password', 'proses-ubah-password*')
        ) {
            return redirect('/reset-password')
                ->with('info', 'Anda wajib mengubah password default sebelum melanjutkan.');
        }

        return $next($request);
    }
}