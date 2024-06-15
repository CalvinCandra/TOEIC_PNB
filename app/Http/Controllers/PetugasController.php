<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankSoal;
use App\Models\Peserta;
use App\Models\Soal;
use App\Models\Gambar;
use App\Models\Audio;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

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

        return view('petugas.content.PetugasPeserta', compact(['peserta']));
    }

    // tambah peserta
    public function TambahPetugasPeserta(Request $request){
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
    
            // Update data ke table peserta 
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
    public function DeletePetugasPeserta(Request $request){

        // get data petugas
        $peserta = Peserta::select('*')->where('id_peserta', $request->id_peserta)->first();

        // transaction database
        try {
            DB::beginTransaction();
            
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

    // tampilan dashboard soal
    public function dashPetugasSoal(Request $request){
        $data = BankSoal::all(); // Ambil semua data dari tabel bank_soal
        return view('petugas.content.petugassoal', compact('data')); // Kirim data ke view
    }

    // tampilan tambah soal
    public function TambahPetugasSoal(Request $request){
        return view('petugas.content.Petugasinputsoal'); 
    }

    public function indext()
    {
        $data = BankSoal::all(); // Ambil semua data dari tabel bank_soal
        $kategoris = Kategori::all(); // Ambil semua kategori

        dd($data, $kategoris);
        return view('petugas.content.petugassoal', compact('data', 'kategoris')); // Kirim data ke view
    }

    public function lihatSoal($idBankSoal)
    {
        $soal = Soal::where('id_bank', $idBankSoal)->get();
        return response()->json($soal);
    }

    public function viewSoal($id_banksoal){
        $soal = Soal::where('id_bank', $id_banksoal)->get();
        return view('petugas.content.petugasbanksoal', compact('soal', 'id_banksoal'));
    }



    // menyimpan soal
    public function simpanSoal(Request $request)
    {

        // Validasi data input
        $request->validate([
            'soal' => 'required|string',
            'jawaban_a' => 'required|string',
            'jawaban_b' => 'required|string',
            'jawaban_c' => 'required|string',
            'jawaban_d' => 'required|string',
            'kunci_jawaban' => 'required|string|in:A,B,C,D',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audio' => 'nullable|mimes:mp3,wav,aac|max:2048',
            'id_bank' => 'required|integer', // Validate id_banksoal
        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $request->file('gambar')->move('imageUserUpload/', $request->file('gambar')->getClientOriginalName());
            $gambarpath = $request->file('gambar')->getClientOriginalName();

            //save to database gambar
            $gambar = Gambar::create([
                'gambar' => $gambarpath,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $id_gambar = $gambar->id_gambar;
        }else{
            $id_gambar = null;
        }

        // Menympan audio jika ada
        if ($request->hasFile('audio')) {
            $request->file('audio')->move('audioUserUpload/', $request->file('audio')->getClientOriginalName());
            $audiopath = $request->file('audio')->getClientOriginalName();

            //save to database gambar
            $audio = Audio::create([
                'audio' => $audiopath,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $id_audio = $audio->id_audio;
        }else{
            $id_audio = null;
        }

        // Menyimpan soal ke database
        Soal::create([
            'soal' => $request->soal,
            'jawaban_a' => $request->jawaban_a,
            'jawaban_b' => $request->jawaban_b,
            'jawaban_c' => $request->jawaban_c,
            'jawaban_d' => $request->jawaban_d,
            'kunci_jawaban' => $request->kunci_jawaban,
            'id_gambar' => $id_gambar ? $id_gambar : null,
            'id_audio' => $id_audio ? $id_audio : null,
            'id_petugas' => Auth::id(), // Mengambil id_petugas dari pengguna yang sedang login
            'id_bank' => $request->id_bank,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil disimpan.');
    }

    public function editSoal(Request $request){
        $request->validate([
            'soal' => 'required|string',
            'jawaban_a' => 'required|string',
            'jawaban_b' => 'required|string',
            'jawaban_c' => 'required|string',
            'jawaban_d' => 'required|string',
            'kunci_jawaban' => 'required|string|in:A,B,C,D',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audio' => 'nullable|mimes:mp3,wav,aac|max:2048',
        ]);

        $soal = Soal::findOrFail($request->input('id_soal'));
        $soal->soal = $request->input('soal');
        $soal->jawaban_a = $request->input('jawaban_a');
        $soal->jawaban_b = $request->input('jawaban_b');
        $soal->jawaban_c = $request->input('jawaban_c');
        $soal->jawaban_d = $request->input('jawaban_d');
        $soal->kunci_jawaban = $request->input('kunci_jawaban');


        //old image and old audio
        $old_image = $request->input('id_gambar');
        $old_audio = $request->input('id_audio');

        // Menyimpan gambar jika ada
        if ($request->hasFile('gambar_new') and $old_image !== null){
            $request->file('gambar_new')->move('imageUserUpload/', $request->file('gambar_new')->getClientOriginalName());
            $gambarpath = $request->file('gambar_new')->getClientOriginalName();

            //save to database gambar
            $gambar = Gambar::findOrFail($old_image);
            unlink('imageUserUpload/'.$gambar->gambar);
            $gambar->gambar = $gambarpath;
            $gambar->save(); 
        }elseif($request->hasFile('gambar_new') and $old_image == null){
            $request->file('gambar_new')->move('imageUserUpload/', $request->file('gambar_new')->getClientOriginalName());
            $gambarpath = $request->file('gambar_new')->getClientOriginalName();

            $gambar = Gambar::create([
                'gambar' => $gambarpath,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $soal->id_gambar = $gambar->id_gambar;
        }

        // Menympan audio jika ada
        if ($request->hasFile('audio_new') and $old_audio !== null){
            $request->file('audio_new')->move('audioUserUpload/', $request->file('audio_new')->getClientOriginalName());
            $audiopath = $request->file('audio_new')->getClientOriginalName();

            //save to database gambar
            $audio = Audio::findOrFail($request->input('id_audio'));
            unlink('audioUserUpload/'.$audio->audio);
            $audio->audio = $audiopath;
            $audio->save();
          
        }elseif($request->hasFile('audio_new') and $old_audio == null){
            $request->file('audio_new')->move('audioUserUpload/', $request->file('audio_new')->getClientOriginalName());
            $audiopath = $request->file('audio_new')->getClientOriginalName();

            $audio = Audio::create([
                'audio' => $audiopath,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $soal->id_audio = $audio->id_audio;
        }
        $soal->save();

        return redirect()->back()->with('success', 'Soal updated successfully.');

    }

    public function deleteSoal($id_soal){
        $soal = Soal::findOrFail($id_soal);
        $soal->delete();

        return redirect()->back()->with('success', 'Soal updated successfully.');
    }

    // ======================================= END PESERTA =====================================
}
