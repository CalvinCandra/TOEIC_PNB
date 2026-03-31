<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function index()
    {
        return view('login');
    }

    public function ProsesLogin(Request $request)
    {
        if (! $request->isMethod('post')) {
            return;
        }

        if (auth()->check()) {
            $level = auth()->user()->level;
            Alert::info('Failed', 'If you have already logged in, please log out first');

            return redirect($this->redirectByLevel($level));
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
            'admin' => '/admin',
            'petugas' => '/petugas',
            default => '/peserta',
        };
    }
}
