<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function index(){
        return view('peserta.content.dashboard');
    }

    public function Profil(){
        $peserta = Peserta::with('user')->where('id_users', auth()->user()->id)->first();
        return view('peserta.content.profil', compact(['peserta']));
    }

    public function UpdateProfil(Request $request){
        if($request->ismethod('post')){
            // transaction database
        try {
            DB::beginTransaction();
            
            // Insert data ke table users menggunakan variavel data
            User::where('id', auth()->user()->id)->update([
                'name' => $request->name,
            ]);
    
            // Insert data ke table petugas 
            Peserta::where('id_users', auth()->user()->id)->update([
                'nama_peserta' => $request->name,
                'nim' => $request->nim,
                'kelamin' => $request->kelamin,
                'jurusan' => $request->jurusan,
            ]);
    
            DB::commit();

            toast('Update Profile Successful!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!','error');
            return redirect()->back();
        }
        }
    }

    public function dashSoal(){
        return view('peserta.content.dashSoal');
    }
}
