<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Audio;
use App\Models\Gambar;
use App\Models\Status;
use App\Models\Peserta;
use App\Models\Petugas;
use App\Models\BankSoal;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasController extends Controller
{
    public function index(Request $request){
        return view('petugas.content.dashboard');
    }

    // ======================================= PESERTA =====================================
    // tampilan dashboard peserta
    public function dashPetugasPeserta(Request $request){
        $search = $request->search;

        if ($search) {
            $peserta = Peserta::with('user')
            ->where('nama_peserta', 'LIKE', '%'.$search.'%')
            ->orWhere('jurusan', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $peserta = Peserta::with('user')->paginate(15);
        }

        return view('petugas.content.Peserta.PetugasPeserta', compact(['peserta']));
    }

    // tambah peserta
    public function TambahPetugasPeserta(Request $request){
        $request->validate([
            'email' => 'email|unique:users',
            'nim' => 'min:10|max:10|unique:peserta'
        ],[
            'nim.max' => 'NIM Must be 10 Letters',
            'nim.min' => 'NIM Must be 10 Letters',
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
            $User = User::where('email', $request->email)->first();
    
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
    public function UpdatePetugasPeserta(Request $request){

        $request->validate([
            'nim' => 'min:10|max:10'
        ],[
            'nim.max' => 'NIM Must be 10 Letters',
            'nim.min' => 'NIM Must be 10 Letters',
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
    
            // Update data ke table peserta 
            Peserta::where('id_peserta', $request->id_peserta)->update([
                'nama_peserta' => $request->name,
                'nim' => $request->nim,
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
    public function DeletePetugasPeserta(Request $request){

        // get data petugas
        $peserta = Peserta::select('*')->where('id_peserta', $request->id_peserta)->first();

        // transaction database
        try {
            DB::beginTransaction();

            // DELETE data status berdasarkan id_peserta
            Status::where('id_peserta', $request->id_peserta)->delete();
            
            // Delete data ke table peserta 
            Peserta::findOrFail($request->id_peserta)->delete();

            // Delete data ke table users
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

    // ======================================= GAMBAR FOR PETUGAS =====================================
    // tampilan dashboard gambar soal
    public function dashPetugasGambar(Request $request){
        $search = $request->search;

        if ($search) {
            $gambar = Gambar::Where('gambar', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $gambar = Gambar::paginate(15);
        }
        return view('petugas.content.Gambar.gambarPetugas', compact('gambar')); // Kirim data ke view
    }

    public function TambahGambarPetugas(Request $request){
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

    public function DeleteGambarPetugas(Request $request){
        if($request->ismethod('post')){

            try {
                // get dat soal yang menggunakan gambar yang mau dihapus dan ubah menjadi null
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


    // ======================================= AUDIO FOR PETUGAS =====================================
    // / tampilan dashboard gambar audio
    public function dashPetugasAudio(Request $request){
        $search = $request->search;

        if ($search) {
            $audio = Audio::Where('gambar', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $audio = Audio::paginate(15);
        }
        return view('petugas.content.Audio.audioPetugas', compact('audio')); // Kirim data ke view
    }

    public function TambahAudioPetugas(Request $request){
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

    public function DeleteAudioPetugas(Request $request){
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


    // ======================================= BANK SOAL FOR PETUGAS=====================================
    // tampilan dashboard bank soal
    public function dashPetugasSoal(Request $request){
        $search = $request->search;

        if ($search) {
            $bank = BankSoal::Where('bank', 'LIKE', '%'.$search.'%')
            ->paginate();
        } else {
            $bank = BankSoal::paginate(15);
        }
        return view('petugas.content.BankSoal.dashbanksoal', compact('bank')); // Kirim data ke view
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
    public function dashPetugasSoalDetailReading(Request $request, $id){
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

        // get penomoran otomatis
        $penomoran = Soal::where('id_bank', $id)->where('kategori', 'Reading')->orderBy('nomor_soal', 'desc')->first();

        // jika blm ada soal
        if($penomoran == null){
            $nomor = intval(0) + 1;
        }else{ //jika sudah ada soal
            $nomor = intval($penomoran->nomor_soal) + 1;
        }

        return view('petugas.content.SoalReading.dashSoalReading', compact(['soal', 'gambar', 'id_bank', 'nomor'])); // Kirim data ke view
    }

    // tambah soal
    public function TambahSoalReadingPetugas(Request $request){

        // generate token otomatis
        $token_soal = strtoupper(Str::password(5, true, true, false, false));

        // get data petugas
        $petugas = Petugas::where('id_users', auth()->user()->id)->first();

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
            'id_petugas' => $petugas->id_petugas,
            'id_bank' => $request->id_bank,
            'token_soal' => $token_soal,
        ]);

        toast('Create Data Successful!','success');
        return redirect()->back();
        
    }

    // update soal 
    public function UpdateSoalReadingPetugas(Request $request){
        if($request->ismethod('post')){

            // get data petugas
            $petugas = Petugas::where('id_users', auth()->user()->id)->first();

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
                'id_petugas' => $petugas->id_petugas,
            ]);
    
            toast('Update Data Successful!','success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteSoalReadingPetugas(Request $request){
        Soal::findOrFail($request->id_soal)->delete();
        toast('Delete Data Successful!','success');
        return redirect()->back();
    }
    // ======================================= SOAL READING =====================================

    // ======================================= SOAL LISTENING =====================================
    public function dashPetugasSoalDetailListening(Request $request, $id){
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

        // get penomoran otomatis
        $penomoran = Soal::where('id_bank', $id)->where('kategori', 'Listening')->orderBy('nomor_soal', 'desc')->first();

        // jika blm ada soal
        if($penomoran == null){
            $nomor = intval(0) + 1;
        }else{ //jika sudah ada soal
            $nomor = intval($penomoran->nomor_soal) + 1;
        }

        return view('petugas.content.SoalListening.dashSoalListening', compact(['soal', 'audio', 'id_bank', 'nomor'])); // Kirim data ke view
    }

    // tambah soal
    public function TambahSoalListeningPetugas(Request $request){

        // generate token otomatis
        $token_soal = strtoupper(Str::password(5, true, true, false, false));

        // get data petugas
        $petugas = Petugas::where('id_users', auth()->user()->id)->first();

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
            'id_petugas' => $petugas->id_petugas,
            'id_bank' => $request->id_bank,
            'token_soal' => $token_soal,
        ]);

        toast('Create Data Successful!','success');
        return redirect()->back();
        
    }

    // update soal 
    public function UpdateSoalListeningPetugas(Request $request){
        if($request->ismethod('post')){

            // get data petugas
            $petugas = Petugas::where('id_users', auth()->user()->id)->first();

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
                'id_petugas' => $petugas->id_petugas,
            ]);
    
            toast('Update Data Successful!','success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteSoalListeningPetugas(Request $request){
        Soal::findOrFail($request->id_soal)->delete();
        toast('Delete Data Successful!','success');
        return redirect()->back();
    }
    // ======================================= END SOAL LISTENING =====================================

}
