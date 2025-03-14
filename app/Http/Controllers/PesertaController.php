<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Status;
use App\Models\Peserta;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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
        $request->validate([
            'nim' => 'min:10|max:10'
        ],[
            'nim.max' => 'NIM Must be 10 Numbers',
            'nim.min' => 'NIM Must be 10 Numbers',
        ]);

         // get data peserta
         $peserta = Peserta::where('id_users', auth()->user()->id)->first();
 
         // cek jika user mengubah email atau tidak
         if($request->nim !== $peserta->nim){
             // Periksa nim ada yang sama atau tidak saat update data baru
             $NimPeserta = Peserta::where('nim', $request->nim)->exists();
             if ($NimPeserta) {
                 return redirect()->back()->withErrors("Nim already exists");
             }
         }

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

    // menampilkan dashboard 
    public function dashSoal(){
        return view('peserta.content.dashSoal');
    }

    public function TokenQuestion(Request $request){
        // get kode bank
        $cekBank = BankSoal::where('bank', $request->bankSoal)->first();

        // get data status
        $peserta = Peserta::where('id_users', auth()->user()->id)->first();

        // pengecekan apakah kode yang diinput ada pada database atau tidak
        if($cekBank){
            // jika token ada, cek apakah user sebelumnya sudah mengerjakan soal ini?
            if($peserta->status == 'Sudah'){
                Alert::info("Information", "You have previously done the questions");
                return redirect('/DashboardSoal');
            }else{
                // pengecekan jika peserta berada pada sesi yang sesuai
                if($cekBank->sesi_bank != $peserta->sesi){
                    Alert::info("Information", "Please wait your turn for the session");
                    return redirect('/DashboardSoal');
                }else{
                    $request->session()->put('bank', $cekBank->bank);
                    return redirect('/Listening');
                }
            }
        }else{
            Alert::error("Failed", "Token Question Not Work");
            return redirect('/DashboardSoal');
        }
    }


}
