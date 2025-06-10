<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Soal;
use App\Models\User;
use App\Models\Audio;
use App\Models\Gambar;
use App\Models\Peserta;
use App\Models\Petugas;
use App\Models\BankSoal;
use App\Models\Kategori;
use App\Imports\UserImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\PesertaExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasController extends Controller
{
    public function index()
    {
        $data = DB::table('peserta')
            ->select('sesi', 'status', DB::raw('COUNT(*) as total'))
            ->whereNotNull('sesi')
            ->groupBy('sesi', 'status')
            ->orderBy('sesi')
            ->get();

        // Format data untuk Chart
        $sessions = $data->pluck('sesi')->unique()->sort()->values();
        $statuses = ['Sudah', 'Kerjain', 'Belum']; // Pastikan sesuai dengan data di database

        $chartData = [];
        foreach ($sessions as $sesi) {
            $chartData[] = [
                'sesi' => $sesi,
                'data' => [
                    'Done' => $data->where('sesi', $sesi)->where('status', 'Sudah')->sum('total') ?? 0,
                    'Work' => $data->where('sesi', $sesi)->where('status', 'Kerjain')->sum('total') ?? 0,
                    'Not Yet' => $data->where('sesi', $sesi)->where('status', 'Belum')->sum('total') ?? 0
                ],
                'total' => $data->where('sesi', $sesi)->sum('total') // Total semua status per sesi
            ];
        }

        return view('petugas.content.dashboard', compact('sessions', 'statuses', 'chartData'));
    }

    // ======================================= PESERTA =====================================
    // tampilan dashboard peserta
    public function dashPetugasPeserta(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $peserta = Peserta::with('user')
                ->where('nama_peserta', 'LIKE', '%' . $search . '%')
                ->orWhere('jurusan', 'LIKE', '%' . $search . '%')
                ->orWhere('nim', 'LIKE', '%' . $search . '%')
                ->paginate();
        } else {
            $peserta = Peserta::with('user')->paginate(15);
        }

        return view('petugas.content.Peserta.PetugasPeserta', compact(['peserta']));
    }

    // tampilan dashboard peserta sesi 1
    public function dashPetugasPeserta1(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $peserta = Peserta::with('user')
                ->where('sesi', 'Session 1')
                ->where(function ($query) use ($search) {
                    $query->where('nama_peserta', 'LIKE', '%' . $search . '%')
                        ->orWhere('jurusan', 'LIKE', '%' . $search . '%')
                        ->orWhere('nim', 'LIKE', '%' . $search . '%');
                })
                ->paginate();
        } else {
            $peserta = Peserta::with('user')->where('sesi', 'Session 1')->paginate(15);
        }

        return view('petugas.content.Peserta.PetugasPeserta1', compact(['peserta']));
    }

    // tampilan dashboard peserta sesi 2
    public function dashPetugasPeserta2(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $peserta = Peserta::with('user')
                ->where('sesi', 'Session 2')
                ->where(function ($query) use ($search) {
                    $query->where('nama_peserta', 'LIKE', '%' . $search . '%')
                        ->orWhere('jurusan', 'LIKE', '%' . $search . '%')
                        ->orWhere('nim', 'LIKE', '%' . $search . '%');
                })
                ->paginate();
        } else {
            $peserta = Peserta::with('user')->where('sesi', 'Session 2')->paginate(15);
        }

        return view('petugas.content.Peserta.PetugasPeserta2', compact(['peserta']));
    }

    // tampilan dashboard peserta sesi 3
    public function dashPetugasPeserta3(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $peserta = Peserta::with('user')
                ->where('sesi', 'Session 3')
                ->where(function ($query) use ($search) {
                    $query->where('nama_peserta', 'LIKE', '%' . $search . '%')
                        ->orWhere('jurusan', 'LIKE', '%' . $search . '%')
                        ->orWhere('nim', 'LIKE', '%' . $search . '%');
                })
                ->paginate();
        } else {
            $peserta = Peserta::with('user')->where('sesi', 'Session 3')->paginate(15);
        }

        return view('petugas.content.Peserta.PetugasPeserta3', compact(['peserta']));
    }

    // tampilan dashboard peserta sesi 4
    public function dashPetugasPeserta4(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $peserta = Peserta::with('user')
                ->where('sesi', 'Session 4')
                ->where(function ($query) use ($search) {
                    $query->where('nama_peserta', 'LIKE', '%' . $search . '%')
                        ->orWhere('jurusan', 'LIKE', '%' . $search . '%')
                        ->orWhere('nim', 'LIKE', '%' . $search . '%');
                })
                ->paginate();
        } else {
            $peserta = Peserta::with('user')->where('sesi', 'Session 4')->paginate(15);
        }

        return view('petugas.content.Peserta.PetugasPeserta4', compact(['peserta']));
    }

    // tambah peserta excel
    public function TambahPesertaExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);

        Excel::import(new UserImport, $request->file);

        if (Session::has('gagal')) {
            return redirect()->back()->with('gagal', Session::get('gagal'));
        } else {
            toast('Create Data Success', 'success');
            return redirect()->back();
        }
    }

    // update peserta
    public function UpdatePetugasPeserta(Request $request)
    {

        $request->validate([
            'nim' => 'min:10|max:10'
        ], [
            'nim.max' => 'NIM Must be 10 Letters',
            'nim.min' => 'NIM Must be 10 Letters',
        ]);

        // get data peserta
        $peserta = Peserta::with('user')->where('id_peserta', $request->id_peserta)->first();

        // cek jika user mengubah email atau tidak
        if ($request->email !== $peserta->user->email) {
            // Periksa email ada yang sama atau tidak saat update data baru
            $EmailUser = User::where('email', $request->email)->exists();
            if ($EmailUser) {
                return redirect()->back()->withErrors("Email already exists");
            }
        }

        // cek jika user mengubah email atau tidak
        if ($request->nim !== $peserta->nim) {
            // Periksa nim ada yang sama atau tidak saat update data baru
            $NimPeserta = Peserta::where('nim', $request->nim)->exists();
            if ($NimPeserta) {
                return redirect()->back()->withErrors("Nim already exists");
            }
        }

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
                'jurusan' => $request->jurusan,
                'sesi' => $request->sesi,
            ]);

            DB::commit();

            toast('Update Data Successful!', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!', 'error');
            return redirect()->back();
        }
    }

    // update status
    public function UpdateStatusPeserta($id)
    {
        try {
            Peserta::where('id_peserta', $id)->update([
                'status' => 'Belum'
            ]);

            toast('Reset Successful!', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            toast('Something Went Wrong!', 'error');
            return redirect()->back();
        }
    }

    // delete peserta
    public function DeletePetugasPeserta(Request $request)
    {

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

            toast('Deleted Data Successful!', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();

            toast('Something Went Wrong!', 'error');
            return redirect()->back();
        }
    }

    // Eksport Excel
    public function ExportExcelPetugas($sesi)
    {
        if ($sesi == 'Sesione') {
            return Excel::download(new PesertaExport($sesi), 'Participation Data Session 1.xlsx');
        } elseif ($sesi == 'Sesitwo') {
            return Excel::download(new PesertaExport($sesi), 'Participation Data Session 2.xlsx');
        } elseif ($sesi == 'Sesithree') {
            return Excel::download(new PesertaExport($sesi), 'Participation Data Session 3.xlsx');
        } else {
            toast('Session Valid', 'error');
            return redirect()->back();
        }
    }

    // Reset Status Work
    public function ResetStatusPetugas($sesi)
    {

        if ($sesi == 'Sesione') {
            Peserta::where('sesi', 'Session 1')->update([
                'status' => 'Belum',
            ]);
        } elseif ($sesi == 'Sesitwo') {
            Peserta::where('sesi', 'Session 2')->update([
                'status' => 'Belum',
            ]);
        } elseif ($sesi == 'Sesithree') {
            Peserta::where('sesi', 'Session 3')->update([
                'status' => 'Belum',
            ]);
        } elseif ($sesi == 'Sesifour') {
            Peserta::where('sesi', 'Session 4')->update([
                'status' => 'Belum',
            ]);
        } else {
            toast('Session Valid', 'error');
            return redirect()->back();
        }

        toast('Reset Status Successful!', 'success');
        return redirect()->back();
    }

    // Delete All Data
    public function DeleteAllPetugas($sesi)
    {

        if ($sesi == 'Sesione') {
            // transaction database
            try {
                DB::beginTransaction();

                // get data id_user di peserta
                $userid = Peserta::where('sesi', 'Session 1')->pluck('id_users');

                // Delete data peserta 
                Peserta::where('sesi', 'Session 1')->delete();

                // Delete data users
                User::whereIn('id', $userid)->where('level', 'peserta')->delete();

                DB::commit();

                toast('Deleted Data Successful!', 'success');
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();

                toast('Something Went Wrong!', 'error');
                return redirect()->back();
            }
        } elseif ($sesi == 'Sesitwo') {
            // transaction database
            try {
                DB::beginTransaction();

                // get data id_user di peserta
                $userid = Peserta::where('sesi', 'Session 2')->pluck('id_users');

                // Delete data peserta 
                Peserta::where('sesi', 'Session 2')->delete();

                // Delete data users
                User::whereIn('id', $userid)->where('level', 'peserta')->delete();

                DB::commit();

                toast('Deleted Data Successful!', 'success');
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();

                toast('Something Went Wrong!', 'error');
                return redirect()->back();
            }
        } elseif ($sesi == 'Sesithree') {
            // transaction database
            try {
                DB::beginTransaction();

                // get data id_user di peserta
                $userid = Peserta::where('sesi', 'Session 3')->pluck('id_users');

                // Delete data peserta 
                Peserta::where('sesi', 'Session 3')->delete();

                // Delete data users
                User::whereIn('id', $userid)->where('level', 'peserta')->delete();

                DB::commit();

                toast('Deleted Data Successful!', 'success');
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();

                toast('Something Went Wrong!', 'error');
                return redirect()->back();
            }
        } else {
            toast('Session Valid', 'error');
            return redirect()->back();
        }
    }

    // download template
    public function Template()
    {
        return Storage::download('public/Template/Participation Data.xlsx');
    }
    // ======================================= END PESERTA =====================================

    // ======================================= GAMBAR FOR PETUGAS =====================================
    // tampilan dashboard gambar soal
    public function dashPetugasGambar(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $gambar = Gambar::Where('gambar', 'LIKE', '%' . $search . '%')
                ->paginate();
        } else {
            $gambar = Gambar::paginate(15);
        }
        return view('petugas.content.Gambar.gambarPetugas', compact('gambar')); // Kirim data ke view
    }

    public function TambahGambarPetugas(Request $request)
    {
        // Validasi request
        $request->validate([
            'gambar' => 'mimes:jpg,jpeg,png'
        ]);

        // get gambar
        $gambar = $request->file('gambar');

        // buat path
        $path = 'gambar/' . $gambar->getClientOriginalName();

        // Periksa apakah gambar dengan nama yang sama sudah ada di database
        $gambarDatabase = Gambar::where('gambar', $gambar->getClientOriginalName())->exists();

        if ($gambarDatabase) {
            return redirect()->back()->withErrors("File Image Exists");
        }

        // Pindahkan ke dalam storage
        Storage::disk('public')->put($path, file_get_contents($gambar));

        // Simpan di database berupa nama
        Gambar::create([
            'gambar' => $gambar->getClientOriginalName(),
        ]);

        toast('Create Data Successful!', 'success');
        return redirect()->back();
    }

    public function DeleteGambarPetugas(Request $request)
    {
        if ($request->isMethod('post')) {
            DB::beginTransaction();

            try {
                // Update data soal yang menggunakan gambar menjadi null
                Soal::where('id_gambar', $request->id_gambar)->update(['id_gambar' => NULL]);

                // Get data gambar dari database
                $gambar = Gambar::findOrFail($request->id_gambar);

                // Tentukan path dari file gambar yang ingin dihapus
                $path = "public/gambar/" . $gambar->gambar;

                // Hapus file dari storage
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }

                // Hapus data gambar dari database
                $gambar->delete();

                DB::commit();

                toast('Deleted Data Successful!', 'success');
                return redirect()->back();
            } catch (\Throwable $th) {
                DB::rollBack();

                toast('Something Went Wrong!', 'error');
                return redirect()->back();
            }
        }
    }
    // ======================================= END GAMBAR =====================================


    // ======================================= AUDIO FOR PETUGAS =====================================
    // / tampilan dashboard gambar audio
    public function dashPetugasAudio(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $audio = Audio::Where('gambar', 'LIKE', '%' . $search . '%')
                ->paginate();
        } else {
            $audio = Audio::paginate(15);
        }
        return view('petugas.content.Audio.audioPetugas', compact('audio')); // Kirim data ke view
    }

    public function TambahAudioPetugas(Request $request)
    {
        $request->validate([
            'audio' => 'mimes:mp3,wav'
        ]);

        // get audio
        $audio = $request->file('audio');

        // buat path
        $path = 'audio/' . $audio->getClientOriginalName();

        // Periksa apakah audio dengan nama yang sama sudah ada di database
        $audioDatabase = Audio::where('audio', $audio->getClientOriginalName())->exists();

        if ($audioDatabase) {
            return redirect()->back()->withErrors("File Audio Exists");
        }

        // Pindahkan ke dalam storage
        Storage::disk('public')->put($path, file_get_contents($audio));

        // Simpan di database berupa nama
        Audio::create([
            'audio' => $audio->getClientOriginalName(),
        ]);

        toast('Create Data Successful!', 'success');
        return redirect()->back();
    }

    public function DeleteAudioPetugas(Request $request)
    {
        if ($request->isMethod('post')) {
            DB::beginTransaction();

            try {
                // Update data soal yang menggunakan gambar menjadi null
                Soal::where('id_audio', $request->id_audio)->update(['id_audio' => NULL]);

                // Get data gambar dari database
                $audio = Audio::findOrFail($request->id_audio);

                // Tentukan path dari file gambar yang ingin dihapus
                $path = "public/audio/" . $audio->audio;

                // Hapus file dari storage
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }

                // Hapus data audio dari database
                $audio->delete();

                DB::commit();

                toast('Deleted Data Successful!', 'success');
                return redirect()->back();
            } catch (\Throwable $th) {
                DB::rollBack();

                toast('Something Went Wrong!', 'error');
                return redirect()->back();
            }
        }
    }
    // ======================================= END AUDIO =====================================


    // ======================================= BANK SOAL FOR PETUGAS=====================================
    // tampilan dashboard bank soal
    public function dashPetugasSoal(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $bank = BankSoal::Where('bank', 'LIKE', '%' . $search . '%')
                ->paginate();
        } else {
            $bank = BankSoal::paginate(15);
        }
        return view('petugas.content.BankSoal.dashbanksoal', compact('bank')); // Kirim data ke view
    }

    public function TambahBankSoal(Request $request)
    {
        $request->validate([
            'bank' => 'unique:bank_soal',
        ]);

        BankSoal::create([
            'bank' => $request->bank,
            'sesi_bank' => $request->sesi_bank,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_akhir' => $request->waktu_akhir,
        ]);

        toast('Create Data Successful!', 'success');
        return redirect()->back();
    }

    public function UpdateBankSoal(Request $request)
    {
        $request->validate([
            'bank' => [
                'required',
                Rule::unique('bank_soal')->ignore($request->id_bank, 'id_bank')
            ],
        ]);

        if ($request->ismethod('post')) {
            BankSoal::where('id_bank', $request->id_bank)->update([
                'bank' => $request->bank,
                'sesi_bank' => $request->sesi_bank,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_akhir' => $request->waktu_akhir,
            ]);

            toast('Update Data Successful!', 'success');
            return redirect()->back();
        }
    }

    public function DeleteBankSoal(Request $request)
    {
        if ($request->ismethod('post')) {

            // transaction database
            try {
                DB::beginTransaction();

                // Delete data Soal berdasarkan bank soal
                Soal::where('id_bank', $request->id_bank)->delete();

                // Delete Part SOal
                Part::where('id_bank', $request->id_bank)->delete();

                // Delete data bank soal
                BankSoal::findOrFail($request->id_bank)->delete();

                DB::commit();

                toast('Deleted Data Successful!', 'success');
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();

                toast('Something Went Wrong!', 'error');
                return redirect()->back();
            }
        }
    }
    // ======================================= END BANK SOAL =====================================

    // ======================================= PART SOAL READING =====================================
    // dash
    public function dashPetugasPartReading(Request $request, $id)
    {
        $search = $request->search;

        if ($search) {
            $part = Part::with(['bank', 'gambar'])
                ->where('id_bank', $id)
                ->where('kategori', 'Reading')
                ->orWhere('part', 'LIKE', '%' . $search . '%')
                ->paginate();
        } else {
            $part = Part::with(['bank', 'gambar'])->where('id_bank', $id)->where('kategori', 'Reading')->paginate(15);
        }

        // lempar id_bank ke dalam view
        $id_bank = $id;

        // get data gambar
        $gambar = Gambar::all();

        // get penomoran otomatis
        $tanda = Part::where('id_bank', $id)->where('kategori', 'Reading')->orderBy('tanda', 'desc')->first();

        // jika blm ada soal
        if ($tanda == null) {
            $nomor = intval(0) + 1;
        } else { //jika sudah ada soal
            $nomor = intval($tanda->tanda) + 1;
        }

        // nomor soal for part
        $nomorSoalListening = Part::where('id_bank', $id)->where('kategori', 'Listening')->orderBy('sampai_nomor', 'desc')->first();
        $nomorSoalReading = Part::where('id_bank', $id)->where('kategori', 'Reading')->orderBy('sampai_nomor', 'desc')->first();

        if ($nomorSoalListening == null && $nomorSoalReading == null) {
            // Tidak ada soal sama sekali
            $angka = 1;
        } elseif ($nomorSoalReading == null) {
            // Belum ada soal Reading, tapi ada soal Listening
            $angka = intval($nomorSoalListening->sampai_nomor) + 1;
        } else {
            // Sudah ada soal Reading
            $angka = intval($nomorSoalReading->sampai_nomor) + 1;
        }

        return view('petugas.content.Part.partReading', compact(['part', 'id_bank', 'gambar', 'nomor', 'angka'])); // Kirim data ke view
    }

    // tambah
    public function TambahReadingPartPetugas(Request $request)
    {

        // generate token otomatis
        $token_part = strtoupper(Str::password(5, true, true, false, false));

        // get part berdasarkan id_bank
        $partSame = Part::where('part', $request->part)->where('kategori', 'Reading')->where('id_bank', $request->id_bank)->first();
        // validasi nama part
        if ($partSame) {
            return redirect()->back()->witherrors('Part Already Exsits');
        }

        // validasi jika inputan sampai nomor lebih kecil dari nomor
        if ($request->dari_nomor >= $request->sampai_nomor) {
            return redirect()->back()->witherrors('Please do not fill in the numbers below ' . $request->dari_nomor);
        }

        Part::create([
            'part' => $request->part,
            'kategori' => 'Reading',
            'petunjuk' => $request->petunjuk,
            'dari_nomor' => $request->dari_nomor,
            'sampai_nomor' => $request->sampai_nomor,
            'token_part' => $token_part,
            'tanda' => $request->tanda,
            'id_bank' => $request->id_bank,
            'id_gambar' => $request->gambar,
            'id_audio' => NULL,
        ]);

        toast('Create Data Successful!', 'success');
        return redirect()->back();
    }

    // update part 
    public function UpdateReadingPartPetugas(Request $request)
    {

        // validasi jika inputan sampai nomor lebih kecil dari nomor
        if ($request->dari_nomor >= $request->sampai_nomor) {
            return redirect()->back()->witherrors('Please do not fill in the numbers below ' . $request->dari_nomor);
        }

        // Ambil part yang sesuai dengan id_part yang diberikan
        $CekPart = Part::where('id_part', $request->id_part)->first();

        // Cek jika nama part yang diinputkan sama dengan part sebelumnya yang ada di database
        if ($CekPart && $CekPart->part != $request->part) { // Jika nama part yang diinputkan berbeda dengan nama part sebelumny
            $partSame = Part::where('part', $request->part)
                ->where('kategori', 'Reading')
                ->where('id_bank', $request->id_bank)
                ->first();
            // cek kembali apakah inputan yang berbeda ada yang sama dengan part lainnya
            if ($partSame) {
                return redirect()->back()->withErrors('Part Already Exists');
            }
        }

        if ($request->ismethod('post')) {

            Part::where('id_part', $request->id_part)->update([
                'part' => $request->part,
                'kategori' => 'Reading',
                'petunjuk' => $request->petunjuk,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => NULL,
            ]);

            toast('Update Data Successful!', 'success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteReadingPartPetugas(Request $request)
    {
        Part::findOrFail($request->id_part)->delete();
        toast('Delete Data Successful!', 'success');
        return redirect()->back();
    }
    // ======================================= END PART SOAL READING =====================================

    // ======================================= PART SOAL LISTENING =====================================
    // dash
    public function dashPetugasPartListening(Request $request, $id)
    {
        $search = $request->search;

        if ($search) {
            $part = Part::with(['bank', 'audio', 'gambar'])
                ->where('id_bank', $id)
                ->where('kategori', 'Listening')
                ->orWhere('part', 'LIKE', '%' . $search . '%')
                ->paginate();
        } else {
            $part = Part::with(['bank', 'audio', 'gambar'])->where('id_bank', $id)->where('kategori', 'Listening')->paginate(15);
        }

        // lempar id_bank ke dalam view
        $id_bank = $id;

        // get data gambar
        $gambar = Gambar::all();

        // get data audio
        $audio = Audio::all();

        // get penomoran otomatis
        $tanda = Part::where('id_bank', $id)->where('kategori', 'Listening')->orderBy('tanda', 'desc')->first();

        // jika blm ada soal
        if ($tanda == null) {
            $nomor = intval(0) + 1;
        } else { //jika sudah ada soal
            $nomor = intval($tanda->tanda) + 1;
        }

        // nomor soal for part
        $nomorSoal = Part::where('id_bank', $id)->where('kategori', 'Listening')->orderBy('sampai_nomor', 'desc')->first();

        // jika blm ada soal
        if ($nomorSoal == null) {
            $angka = intval(0) + 1;
        } else { //jika sudah ada soal
            $angka = intval($nomorSoal->sampai_nomor) + 1;
        }

        return view('petugas.content.Part.partListening', compact(['part', 'id_bank', 'gambar', 'audio', 'nomor', 'angka'])); // Kirim data ke view
    }

    // tambah
    public function TambahListeningPartPetugas(Request $request)
    {

        // Validasi inputan form
        $validated = $request->validate([
            'petunjuk' => 'required|string',
        ], [
            'petunjuk.required' => "Direction cannot be empty"
        ]);

        // generate token otomatis
        $token_part = strtoupper(Str::password(5, true, true, false, false));

        // get part berdasarkan id_bank
        $partSame = Part::where('part', $request->part)->where('kategori', 'Listening')->where('id_bank', $request->id_bank)->first();
        // validasi nama part
        if ($partSame) {
            return redirect()->back()->witherrors('Part Already Exsits');
        }

        // validasi jika inputan sampai nomor lebih kecil dari nomor
        if ($request->dari_nomor >= $request->sampai_nomor) {
            return redirect()->back()->witherrors('Please do not fill in the numbers below ' . $request->dari_nomor);
        }

        Part::create([
            'part' => $request->part,
            'kategori' => 'Listening',
            'petunjuk' => $request->petunjuk,
            'dari_nomor' => $request->dari_nomor,
            'sampai_nomor' => $request->sampai_nomor,
            'token_part' => $token_part,
            'tanda' => $request->tanda,
            'id_bank' => $request->id_bank,
            'id_gambar' => $request->gambar,
            'id_audio' => $request->audio,
        ]);

        toast('Create Data Successful!', 'success');
        return redirect()->back();
    }

    // update part 
    public function UpdateListeningPartPetugas(Request $request)
    {

        // validasi jika inputan sampai nomor lebih kecil dari nomor
        if ($request->dari_nomor >= $request->sampai_nomor) {
            return redirect()->back()->witherrors('Please do not fill in the numbers below ' . $request->dari_nomor);
        }

        // Ambil part yang sesuai dengan id_part yang diberikan
        $CekPart = Part::where('id_part', $request->id_part)->first();

        // Cek jika nama part yang diinputkan sama dengan part sebelumnya yang ada di database
        if ($CekPart && $CekPart->part != $request->part) { // Jika nama part yang diinputkan berbeda dengan nama part sebelumny
            $partSame = Part::where('part', $request->part)
                ->where('kategori', 'Listening')
                ->where('id_bank', $request->id_bank)
                ->first();
            // cek kembali apakah inputan yang berbeda ada yang sama dengan part lainnya
            if ($partSame) {
                return redirect()->back()->withErrors('Part Already Exists');
            }
        }

        if ($request->ismethod('post')) {

            Part::where('id_part', $request->id_part)->update([
                'part' => $request->part,
                'kategori' => 'Listening',
                'petunjuk' => $request->petunjuk,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => $request->audio,
            ]);

            toast('Update Data Successful!', 'success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteListeningPartPetugas(Request $request)
    {
        Part::findOrFail($request->id_part)->delete();
        toast('Delete Data Successful!', 'success');
        return redirect()->back();
    }
    // ======================================= END PART SOAL READING =====================================

    // ======================================= SOAL READING =====================================
    // menampilkan data soal
    public function dashPetugasSoalDetailReading(Request $request, $id)
    {
        $search = $request->search;

        if ($search) {
            $soal = Soal::with(['user', 'gambar'])
                ->where('id_bank', $id)
                ->where('kategori', 'Reading')
                ->orWhere('nomor', 'LIKE', '%' . $search . '%')
                ->orWhere('soal', 'LIKE', '%' . $search . '%')
                ->orderBy('nomor_soal', 'asc')
                ->paginate();
        } else {
            $soal = Soal::with(['user', 'gambar'])->where('id_bank', $id)->where('kategori', 'Reading')->orderBy('nomor_soal', 'asc')->paginate(15);
        }

        // lempar id_bank ke dalam view
        $id_bank = $id;

        // get data gambar
        $gambar = Gambar::all();

        // get penomoran otomatis dari Listening ke Reading
        $penomoranListening = Soal::where('id_bank', $id)->where('kategori', 'Listening')->orderBy('nomor_soal', 'desc')->first();
        $penomoranReading = Soal::where('id_bank', $id)->where('kategori', 'Reading')->orderBy('nomor_soal', 'desc')->first();

        if ($penomoranListening == null && $penomoranReading == null) {
            // Tidak ada soal sama sekali
            $nomor = 1;
        } elseif ($penomoranReading == null) {
            // Belum ada soal Reading, tapi ada soal Listening
            $nomor = intval($penomoranListening->nomor_soal) + 1;
        } else {
            // Sudah ada soal Reading
            $nomor = intval($penomoranReading->nomor_soal) + 1;
        }

        return view('petugas.content.SoalReading.dashSoalReading', compact(['soal', 'gambar', 'id_bank', 'nomor'])); // Kirim data ke view
    }

    // tambah soal
    public function TambahSoalReadingPetugas(Request $request)
    {

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
            'id_gambar_1' => $request->gambar1,
            'id_gambar_2' => $request->gambar2,
            'id_audio' => NULL,
            'id_users' => auth()->user()->id,
            'id_bank' => $request->id_bank,
            'token_soal' => $token_soal,
        ]);

        toast('Create Data Successful!', 'success');
        return redirect()->back();
    }

    // update soal 
    public function UpdateSoalReadingPetugas(Request $request)
    {
        if ($request->ismethod('post')) {

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
                'id_gambar_1' => $request->gambar1,
                'id_gambar_2' => $request->gambar2,
                'id_users' => auth()->user()->id,
            ]);

            toast('Update Data Successful!', 'success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteSoalReadingPetugas(Request $request)
    {
        Soal::findOrFail($request->id_soal)->delete();
        toast('Delete Data Successful!', 'success');
        return redirect()->back();
    }
    // ======================================= SOAL READING =====================================

    // ======================================= SOAL LISTENING =====================================
    public function dashPetugasSoalDetailListening(Request $request, $id)
    {
        $search = $request->search;

        if ($search) {
            $soal = Soal::with(['user', 'audio'])
                ->where('id_bank', $id)
                ->where('kategori', 'Listening')
                ->orWhere('nomor', 'LIKE', '%' . $search . '%')
                ->orWhere('soal', 'LIKE', '%' . $search . '%')
                ->paginate();
        } else {
            $soal = Soal::with(['user', 'audio'])->where('id_bank', $id)->where('kategori', 'Listening')->paginate(15);
        }

        // lempar id_bank ke dalam view
        $id_bank = $id;

        // get data gambar
        $audio = Audio::all();

        // get data gambar
        $gambar = Gambar::all();

        // get penomoran otomatis
        $penomoran = Soal::where('id_bank', $id)->where('kategori', 'Listening')->orderBy('nomor_soal', 'desc')->first();

        // jika blm ada soal
        if ($penomoran == null) {
            $nomor = intval(0) + 1;
        } else { //jika sudah ada soal
            $nomor = intval($penomoran->nomor_soal) + 1;
        }

        return view('petugas.content.SoalListening.dashSoalListening', compact(['soal', 'audio', 'id_bank', 'nomor', 'gambar'])); // Kirim data ke view
    }

    // tambah soal
    public function TambahSoalListeningPetugas(Request $request)
    {

        // generate token otomatis
        $token_soal = strtoupper(Str::password(5, true, true, false, false));

        Soal::create([
            'nomor_soal' => $request->nomor_soal,
            'text' => NULL,
            'soal' => $request->soal,
            'jawaban_a' => $request->jawaban_a,
            'jawaban_b' => $request->jawaban_b,
            'jawaban_c' => $request->jawaban_c,
            'jawaban_d' => $request->jawaban_d,
            'kunci_jawaban' => strtoupper($request->kunci_jawaban),
            'kategori' => 'Listening',
            'id_gambar' => $request->gambar,
            // 'id_audio' => $request->audio,
            'id_audio' => NULL,
            'id_users' => auth()->user()->id,
            'id_bank' => $request->id_bank,
            'token_soal' => $token_soal,
        ]);

        toast('Create Data Successful!', 'success');
        return redirect()->back();
    }

    // update soal 
    public function UpdateSoalListeningPetugas(Request $request)
    {
        if ($request->ismethod('post')) {

            Soal::where('id_soal', $request->id_soal)->update([
                'nomor_soal' => $request->nomor_soal,
                'text' => NULL,
                'soal' => $request->soal,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'kunci_jawaban' => strtoupper($request->kunci_jawaban),
                // 'id_audio' => $request->audio,
                'id_audio' => NULL,
                'id_gambar' => $request->gambar,
                'id_users' => auth()->user()->id,
            ]);

            toast('Update Data Successful!', 'success');
            return redirect()->back();
        }
    }

    // delete soal
    public function DeleteSoalListeningPetugas(Request $request)
    {
        Soal::findOrFail($request->id_soal)->delete();
        toast('Delete Data Successful!', 'success');
        return redirect()->back();
    }
    // ======================================= END SOAL LISTENING =====================================

}
