<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
                Alert::error("Failed", "Username Or Password Not Same");
                return redirect('/');
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
