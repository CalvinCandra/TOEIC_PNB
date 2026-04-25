<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Tampilkan halaman login.
     *
     * Header Cache-Control: no-store → browser tidak boleh cache halaman ini.
     *
     * Fix back button:
     * (1) Setelah logout → tekan Back → browser fetch ulang ke server
     *     → middleware auth belum login → redirect /login
     *     → tampil halaman login, bukan halaman protected dari cache ✅
     *
     * (2) Sudah login → tekan Back ke /login → browser fetch ulang
     *     → RedirectIfAuthenticated → redirect ke dashboard ✅
     */
    public function index()
    {
        return response()
            ->view('login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function ProsesLogin(Request $request)
    {
        // Jika sudah login, jangan proses ulang — redirect sesuai level
        if (auth()->check()) {
            Alert::info('Failed', 'If you have already logged in, please log out first');

            return redirect($this->redirectByLevel(auth()->user()->level));
        }

        $level = $this->authService->attempt($request);

        if ($level) {
            if ($level !== 'peserta') {
                toast('Login Successful!', 'success');
            }

            return redirect($this->redirectByLevel($level));
        }

        Alert::error('Failed', 'Username Or Password Not Same');

        return redirect('/login');
    }

    public function Logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect('/');
    }

    private function redirectByLevel(string $level): string
    {
        return match ($level) {
            'admin'   => '/admin',
            'petugas' => '/petugas',
            default   => '/peserta',
        };
    }
}