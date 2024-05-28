<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
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
    // ======================================= END PESERTA =====================================
}
