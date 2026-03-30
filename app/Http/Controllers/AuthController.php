<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    // login view
    public function index(Request $request)
    {
        return view('login');
    }

    // proses login
    public function ProsesLogin(Request $request){
        if($request->isMethod('post')){

            Log::info('[AuthController::ProsesLogin] Percobaan login', [
                'email' => $request->email,
                'ip'    => $request->ip(),
            ]);

            $data = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            if(auth()->check()){
                $user = auth()->user();
                Log::warning('[AuthController::ProsesLogin] User sudah login, redirect ke halaman level', [
                    'email' => $user->email,
                    'level' => $user->level,
                ]);
                if($user->level == 'admin'){
                    Alert::info("Failed", "If you have already logged in, please log out first");
                    return redirect('/admin');
                }elseif($user->level == 'petugas'){
                    Alert::info("Failed", "If you have already logged in, please log out first");
                    return redirect('/petugas');
                }else{
                    Alert::info("Failed", "If you have already logged in, please log out first");
                    return redirect('/peserta');
                }
            }else{
                if (Auth::attempt($data)) {
    
                    $request->session()->regenerate();
                    
                    $User = User::where('email', $request->email)->first();
                    $level = $User->level;

                    Log::info('[AuthController::ProsesLogin] Login berhasil', [
                        'email' => $request->email,
                        'level' => $level,
                        'ip'    => $request->ip(),
                    ]);
                    
                    //membawa ke halaman sesuai level
                    if($level == "admin"){
                        toast('Login Successful!','success');
                        return redirect('/admin');
                    }elseif($level == "petugas"){
                        toast('Login Successful!','success');
                        return redirect('/petugas');
                    }else{
                        return redirect('/peserta');
                    }
                }else{
                   Log::warning('[AuthController::ProsesLogin] Login gagal - kredensial salah', [
                       'email' => $request->email,
                       'ip'    => $request->ip(),
                   ]);
                   Alert::error("Failed", "Username Or Password Not Same");
                   return redirect('/login')->with('gagal', 'Username Atau Password Salah !');
                }
            }
        }
    }

    // proses logout
    public function Logout(Request $request){
        Log::info('[AuthController::Logout] User logout', [
            'email' => auth()->user()?->email,
            'level' => auth()->user()?->level,
        ]);
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
