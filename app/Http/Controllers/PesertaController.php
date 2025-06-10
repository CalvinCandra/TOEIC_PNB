<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\User;
use App\Models\Status;
use App\Models\Peserta;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function DownloadResutl(Request $request){
        $peserta = Peserta::with('user')->where('id_users', auth()->user()->id)->first();
        
        if(!$peserta){
            Alert::info("Information", "Data User, Cant Get");
            return redirect('/Profil');
        }

        // cek sesi folder
        if($peserta->sesi == 'Session 1'){
            $sesi = 'session_1';
        }elseif($peserta->sesi == 'Session 2'){
            $sesi = 'session_2';
        }elseif($peserta->sesi == 'Session 3'){
            $sesi = 'session_3';
        }elseif($peserta->sesi == 'Session 4'){
            $sesi = 'session_4';
        }elseif($peserta->sesi == 'Session 5'){
            $sesi = 'session_5';
        }elseif($peserta->sesi == 'Session 6'){
            $sesi = 'session_6';
        }elseif($peserta->sesi == 'Session 7'){
            $sesi = 'session_7';
        }elseif($peserta->sesi == 'Session 8'){
            $sesi = 'session_8';
        }

        $folder = storage_path('app/public/result/'.$sesi);
        $pattern = 'Result_' . $peserta->nim . '_' . $peserta->sesi . '_*.pdf';

        // Cari semua file yang cocok
        $files = glob($folder . '/' . $pattern);

         if (empty($files)) {
            Alert::info("Information", "Result file not found");
            return redirect('/Profil');
        }

         // Urutkan berdasarkan waktu terbaru
        usort($files, function ($a, $b) {
            return filemtime($b) - filemtime($a); // terbaru duluan
        });

        // Ambil file pertama
        $filepath = $files[0];
        $filename = basename($filepath);

        // Download
        return Storage::disk('public')->download('result/' . $sesi . '/' . $filename);
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
        if ($cekBank) {
            // jika token ada, cek apakah user sebelumnya sudah mengerjakan soal ini?
            if ($peserta->status == 'Sudah' || $peserta->status == 'Kerjain') {
                Alert::info("Information", "You have previously done the questions");
                return redirect('/DashboardSoal');
            } else {
                // pengecekan jika peserta berada pada sesi yang sesuai
                if ($cekBank->sesi_bank != $peserta->sesi) {
                    Alert::info("Information", "Please wait your turn for the session");
                    return redirect('/DashboardSoal');
                } else {
                    // Ambil waktu sekarang sesuai zona waktu Asia/Singapore
                    $currentTime = Carbon::now('Asia/Singapore');

                    // Ambil waktu mulai dan akhir dari database dan ubah menjadi objek Carbon dengan tanggal yang sama seperti $currentTime
                    $waktuMulai = Carbon::parse($cekBank->waktu_mulai)->setDate($currentTime->year, $currentTime->month, $currentTime->day); 
                    $waktuAkhir = Carbon::parse($cekBank->waktu_akhir)->setDate($currentTime->year, $currentTime->month, $currentTime->day); 
                    
                    // pengecekan waktu
                    if ($currentTime->lt($waktuMulai) || $currentTime->gt($waktuAkhir)) {
                        Alert::info("Information", "Token cannot be accessed due to timeout");
                        return redirect('/DashboardSoal');
                    }

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
