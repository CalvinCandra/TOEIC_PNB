<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        
        return view('admin.content.AdminPegawai', compact(['petugas']));
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

        return view('admin.content.AdminPeserta', compact(['peserta']));
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

}
