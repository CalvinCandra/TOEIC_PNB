<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login view
    public function index(Request $request){
        return view('login');
    }

    // proses login
    public function ProsesLogin(Request $request){
        if($request->isMethod('post')){

            $data = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            if (Auth::attempt($data)) {
    
                $request->session()->regenerate();
                
                $User = User::where('email', $request->email)->first();
                $level = $User->level;
                
                //membawa ke halaman sesuai level
                if($level == "admin")
                    return redirect('/admin');
                elseif($level == "petugas"){
                    return redirect('/petugas');
                }else{
                    return redirect('/');
                }
            }else{
                return redirect('/login')->with('gagal', 'Username Atau Password Salah !');
            }
        }
    }

    // proses logout
    public function Logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
