<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Audio;
use App\Models\Gambar;
use App\Models\Status;
use App\Models\Peserta;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // tampilan dashboard
    public function index(Request $request){
        return view('admin.content.dashboard');
    }

    // ======================================= PETUGAS =====================================
    // tampilan dashboard PETUGAS
    public function dashPetugas(Request $request){
        $search = $request->search;

        if ($search) {
            $petugas = Petugas::with('user')->where('nama_petugas', 'LIKE', '%'.$search.'%')->paginate();
        } else {
            $petugas = Petugas::with('user')->paginate(15);
        }
        
        return view('admin.content.Pegawai.AdminPegawai', compact(['petugas']));
    }

    // tambah petugas
    public function TambahPetugas(Request $request){
        $request->validate([
            'email' => 'email|unique:users'
        ]);

        // generate password otomatis
        $password = strtoupper(Str::password(8, true, false, false, false));

        // transaction database
        try {
            DB::beginTransaction();
            
            // Insert data ke table users menggunakan variavel data
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'level' => 'petugas',
            ]);

            // get id berdasarkan data yang baru ditambah
            $User = User::select('*')->where('email', $request->email)->first();
    
            // Insert data ke table petugas 
            Petugas::create([
                'nama_petugas' => $request->name,
                'token' => $password,
                'id_users' => $User['id'],
            ]);
    
            DB::commit();

            toast('Create Data Successful!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!','error');
            return redirect()->back();
        }
    }

    // update petugas
    public function UpdatePetugas(Request $request){

        // get data petugas
        $petugas = Petugas::select('*')->where('id_petugas', $request->id_petugas)->first();

        // transaction database
        try {
            DB::beginTransaction();
            
            // Update data ke table users
            User::where('id', $petugas['id_users'])->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
    
            // Update data ke table petugas 
            Petugas::where('id_petugas', $request->id_petugas)->update([
                'nama_petugas' => $request->name,
            ]);
    
            DB::commit();

            toast('Update Data Successful!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!','error');
            return redirect()->back();
        }
    }

    // delete petugas
    public function DeletePetugas(Request $request){

        // get data petugas
        $petugas = Petugas::select('*')->where('id_petugas', $request->id_petugas)->first();

        // transaction database
        try {
            DB::beginTransaction();

            // Delete data ke table petugas 
            Petugas::findOrFail($request->id_petugas)->delete();
            
            // Delete data ke table users 
            User::findOrFail($petugas['id_users'])->delete();
    
    
            DB::commit();

            toast('Deleted Data Successful!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!','error');
            return redirect()->back();
        }
    }
    // ======================================= END PETUGAS =====================================


    // ======================================= PESERTA =====================================
    // tampilan dashboard peserta
    public function dashPeserta(Request $request){
        $search = $request->search;

        if ($search) {
            $peserta = Peserta::with('user')
            ->where('nama_peserta', 'LIKE', '%'.$search.'%')
            ->orWhere('jurusan', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $peserta = Peserta::with('user')->paginate(15);
        }

        return view('admin.content.Peserta.AdminPeserta', compact(['peserta']));
    }

    // tambah peserta
    public function TambahPeserta(Request $request){
        $request->validate([
            'email' => 'email|unique:users',
            'nim' => 'min:10|max:10|unique:peserta'
        ],[
            'nim.max' => 'NIM Must be 3 Letters',
            'nim.min' => 'NIM Must be 3 Letters',
        ]);

        // generate password otomatis
        $password = strtoupper(Str::password(8, true, false, false, false));

        // transaction database
        try {
            DB::beginTransaction();
            
            // Insert data ke table users menggunakan variavel data
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'level' => 'peserta',
            ]);

            // get id berdasarkan data yang baru ditambah
            $User = User::select('*')->where('email', $request->email)->first();
    
            // Insert data ke table petugas 
            Peserta::create([
                'nama_peserta' => $request->name,
                'nim' => $request->nim,
                'token' => $password,
                'kelamin' => $request->kelamin,
                'jurusan' => $request->jurusan,
                'id_users' => $User['id'],
            ]);

            // get id_peserta berdasarkan data yang baru ditambah
            $Peserta = Peserta::where('id_users', $User['id'])->first();

            // insert data ke table status
            Status::create([
                'status_pengerjaan' => 'Belum',
                'id_peserta' => $Peserta['id_peserta'],
            ]);
    
            DB::commit();

            toast('Create Data Successful!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!','error');
            return redirect()->back();
        }
    }

    // update peserta
    public function UpdatePeserta(Request $request){

        $request->validate([
            'nim' => 'min:10|max:10'
        ],[
            'nim.max' => 'NIM Must be 3 Letters',
            'nim.min' => 'NIM Must be 3 Letters',
        ]);

        // get data petugas
        $peserta = Peserta::select('*')->where('id_peserta', $request->id_peserta)->first();

        // transaction database
        try {
            DB::beginTransaction();
            
            // Update data ke table users
            User::where('id', $peserta['id_users'])->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
    
            // Update data ke table petugas 
            Peserta::where('id_peserta', $request->id_peserta)->update([
                'nama_peserta' => $request->name,
                'kelamin' => $request->kelamin,
                'jurusan' => $request->jurusan,
            ]);
    
            DB::commit();

            toast('Update Data Successful!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!','error');
            return redirect()->back();
        }
    }

    // delete peserta
    public function DeletePeserta(Request $request){

        // get data petugas
        $peserta = Peserta::select('*')->where('id_peserta', $request->id_peserta)->first();

        // transaction database
        try {
            DB::beginTransaction();
            
            // DELETE data ke table petugas 
            Peserta::findOrFail($request->id_peserta)->delete();

            // DELETE data ke table users
            User::findOrFail($peserta['id_users'])->delete();
    
            DB::commit();

            toast('Deleted Data Successful!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!','error');
            return redirect()->back();
        }
    }
    // ======================================= END PESERTA =====================================

    // ======================================= GAMBAR FOR ADMIN =====================================
    // tampilan dashboard gambar soal
    public function dashAdminGambar(Request $request){
        $search = $request->search;

        if ($search) {
            $gambar = Gambar::Where('gambar', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $gambar = Gambar::paginate(15);
        }
        return view('admin.content.Gambar.gambarAdmin', compact('gambar')); // Kirim data ke view
    }

    public function TambahGambarAdmin(Request $request){
        $request->validate([
            'gambar' => 'mimes:jpg,jpeg,png'
        ]);

        // get gambar
        $gambar = $request->file('gambar');

        // buat path
        $path = 'gambar/' .$gambar->getClientOriginalName();

        // pindahkan ke dalam storage
        Storage::disk('public')->put($path, file_get_contents($gambar));

        // simpan di database berupa nama
        Gambar::create([
            'gambar' => $gambar->getClientOriginalName(),
        ]);
        
        toast('Create Data Successful!','success');
        return redirect()->back();
    }

    public function DeleteGambarAdmin(Request $request){
        if($request->ismethod('post')){

            try {
                // get dat soal yang menggunakan audio yang mau dihapus dan ubah menjadi null
                $soal = Soal::where('id_gambar', $request->id_gambar)->update([
                    'id_gambar' => NULL
                ]);

                // get data dari database
                $gambar = Gambar::findOrFail($request->id_gambar)->first();

                // buat path
                $path = 'gambar/' .$gambar->gambar;

                // hapus data dari storage
                Storage::disk('public')->delete($path);

                // hapus data dari database
                Gambar::findOrFail($request->id_gambar)->delete();
            
                toast('Deleted Data Successful!','success');
                return redirect()->back();

            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();
    
                toast('Something Went Wrong!','error');
                return redirect()->back();
            }
        }
    }
    // ======================================= END GAMBAR =====================================


    // ======================================= AUDIO FOR ADMIN =====================================
    // / tampilan dashboard gambar audio
    public function dashAdminAudio(Request $request){
        $search = $request->search;

        if ($search) {
            $audio = Audio::Where('gambar', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $audio = Audio::paginate(15);
        }
        return view('admin.content.Audio.audioAdmin', compact('audio')); // Kirim data ke view
    }

    public function TambahAudioAdmin(Request $request){
        $request->validate([
            'audio' => 'mimes:mp3,wav'
        ]);

        // get gambar
        $audio = $request->file('audio');

        // buat path
        $path = 'audio/' .$audio->getClientOriginalName();

        // pindahkan ke dalam storage
        Storage::disk('public')->put($path, file_get_contents($audio));

        // simpan di database berupa nama
        Audio::create([
            'audio' => $audio->getClientOriginalName(),
        ]);
        
        toast('Create Data Successful!','success');
        return redirect()->back();
    }

    public function DeleteAudioAdmin(Request $request){
        if($request->ismethod('post')){

            try {
                // get dat soal yang menggunakan audio yang mau dihapus dan ubah menjadi null
                $soal = Soal::where('id_audio', $request->id_audio)->update([
                    'id_audio' => NULL
                ]);

                // get data dari database
                $audio = Audio::findOrFail($request->id_audio)->first();

                // buat path
                $path = 'audio/' .$audio->audio;

                // hapus data dari storage
                Storage::disk('public')->delete($path);

                // hapus data dari database
                Audio::findOrFail($request->id_audio)->delete();
            
                toast('Deleted Data Successful!','success');
                return redirect()->back();

            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();
    
                toast('Something Went Wrong!','error');
                return redirect()->back();
            }

        }
    }
    // ======================================= END AUDIO =====================================


    // ======================================= BANK SOAL FOR ADMIN =====================================
    // tampilan dashboard bank soal
    public function dashAdminSoal(Request $request){
        $search = $request->search;

        if ($search) {
            $bank = BankSoal::Where('bank', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $bank = BankSoal::paginate(15);
        }
        return view('admin.content.BankSoal.dashbanksoal', compact('bank')); // Kirim data ke view
    }

    public function TambahBankSoal(Request $request){
        $request->validate([
            'bank' => 'unique:bank_soal',
        ]);

        BankSoal::create([
            'bank' => $request->bank,
        ]);
        
        toast('Create Data Successful!','success');
        return redirect()->back();
    }

    public function UpdateBankSoal(Request $request){
        $request->validate([
            'bank' => 'unique:bank_soal',
        ]);

        if($request->ismethod('post')){
            BankSoal::where('id_bank', $request->id_bank)->update([
                'bank' => $request->bank,
            ]);
            
            toast('Update Data Successful!','success');
            return redirect()->back();
        }

    }

    public function DeleteBankSoal(Request $request){
        if($request->ismethod('post')){

            // transaction database
            try {
                DB::beginTransaction();
                
                // Delete data Soal berdasarkan bank soal
                Soal::where('id_bank', $request->id_bank)->delete();

                // Delete data bank soal
                BankSoal::findOrFail($request->id_bank)->delete();
        
                DB::commit();

                toast('Deleted Data Successful!','success');
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();

                toast('Something Went Wrong!','error');
                return redirect()->back();
            }
        }

    }
    // ======================================= END BANK SOAL =====================================


    // ======================================= SOAL READING =====================================
    // menampilkan data soal
    public function dashAdminSoalDetailReading(Request $request, $id){
        $search = $request->search;

        if ($search) {
            $soal = Soal::
            with(['petugas', 'gambar'])
            ->where('id_bank', $id)
            ->where('kategori', 'Reading')
            ->orWhere('nomor', 'LIKE', '%'.$search.'%')
            ->orWhere('soal', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $soal = Soal::with(['petugas', 'gambar'])->where('id_bank', $id)->where('kategori', 'Reading')->paginate(15);
        }

        // lempar id_bank ke dalam view
        $id_bank = $id;

        // get data gambar
        $gambar = Gambar::all();

        return view('admin.content.SoalReading.dashSoalReading', compact(['soal', 'gambar', 'id_bank'])); // Kirim data ke view
    }

    // tambah soal
    public function TambahSoalReadingAdmin(Request $request){
        $request->validate([
            'kunci_jawaban' => 'min:1|max:1'
        ],[
            'kunci_jawaban.max' => 'Key Must be 1 Letters',
            'kunci_jawaban.min' => 'Key Must be 1 Letters',
        ]);

        // generate token otomatis
        $token_soal = strtoupper(Str::password(5, true, true, false, false));

        Soal::create([
            'nomor_soal' => $request->nomor_soal,
            'text' => $request->text,
            'soal' => $request->soal,
            'jawaban_a' => $request->jawaban_a,
            'jawaban_b' => $request->jawaban_b,
            'jawaban_c' => $request->jawaban_c,
            'jawaban_d' => $request->jawaban_d,
            'kunci_jawaban' => strtoupper($request->kunci_jawaban),
            'kategori' => 'Reading',
            'id_gambar' => $request->gambar,
            'id_audio' => NULL,
            'id_petugas' => 0,
            'id_bank' => $request->id_bank,
            'token_soal' => $token_soal,
        ]);

        toast('Create Data Successful!','success');
        return redirect()->back();
        
    }

    // update soal 
    public function UpdateSoalReadingAdmin(Request $request){
        if($request->ismethod('post')){

            Soal::where('id_soal', $request->id_soal)->update([
                'nomor_soal' => $request->nomor_soal,
                'text' => $request->text,
                'soal' => $request->soal,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'kunci_jawaban' => strtoupper($request->kunci_jawaban),
                'id_gambar' => $request->gambar,
                'id_petugas' => 0,
            ]);
    
            toast('Update Data Successful!','success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteSoalReadingAdmin(Request $request){
        Soal::findOrFail($request->id_soal)->delete();
        toast('Delete Data Successful!','success');
        return redirect()->back();
    }
    // ======================================= SOAL READING =====================================

    // ======================================= SOAL LISTENING =====================================
    public function dashAdminSoalDetailListening(Request $request, $id){
        $search = $request->search;

        if ($search) {
            $soal = Soal::
            with(['petugas', 'audio'])
            ->where('id_bank', $id)
            ->where('kategori', 'Listening')
            ->orWhere('nomor', 'LIKE', '%'.$search.'%')
            ->orWhere('soal', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $soal = Soal::with(['petugas', 'audio'])->where('id_bank', $id)->where('kategori', 'Listening')->paginate(15);
        }

        // lempar id_bank ke dalam view
        $id_bank = $id;

        // get data gambar
        $audio = Audio::all();

        return view('admin.content.SoalListening.dashSoalListening', compact(['soal', 'audio', 'id_bank'])); // Kirim data ke view
    }

    // tambah soal
    public function TambahSoalListeningAdmin(Request $request){
        $request->validate([
            'kunci_jawaban' => 'min:1|max:1'
        ],[
            'kunci_jawaban.max' => 'Key Must be 1 Letters',
            'kunci_jawaban.min' => 'Key Must be 1 Letters',
        ]);

        // generate token otomatis
        $token_soal = strtoupper(Str::password(5, true, true, false, false));

        Soal::create([
            'nomor_soal' => $request->nomor_soal,
            'text' => $request->text,
            'soal' => $request->soal,
            'jawaban_a' => $request->jawaban_a,
            'jawaban_b' => $request->jawaban_b,
            'jawaban_c' => $request->jawaban_c,
            'jawaban_d' => $request->jawaban_d,
            'kunci_jawaban' => strtoupper($request->kunci_jawaban),
            'kategori' => 'Listening',
            'id_gambar' => NULL,
            'id_audio' => $request->audio,
            'id_petugas' => 0,
            'id_bank' => $request->id_bank,
            'token_soal' => $token_soal,
        ]);

        toast('Create Data Successful!','success');
        return redirect()->back();
        
    }

    // update soal 
    public function UpdateSoalListeningAdmin(Request $request){
        if($request->ismethod('post')){

            Soal::where('id_soal', $request->id_soal)->update([
                'nomor_soal' => $request->nomor_soal,
                'text' => $request->text,
                'soal' => $request->soal,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'kunci_jawaban' => strtoupper($request->kunci_jawaban),
                'id_audio' => $request->audio,
                'id_petugas' => 0,
            ]);
    
            toast('Update Data Successful!','success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteSoalListeningAdmin(Request $request){
        Soal::findOrFail($request->id_soal)->delete();
        toast('Delete Data Successful!','success');
        return redirect()->back();
    }
    // ======================================= END SOAL LISTENING =====================================

}
