<?php

namespace App\Services\Peserta;

use App\Exports\PesertaExport;
use App\Imports\UserImport;
use App\Models\Peserta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PesertaService
{
    public function getPesertaAll(?string $search = null)
    {
        Log::info('[PesertaService::getPesertaAll] Mengambil semua peserta', [
            'search' => $search,
        ]);

        return Peserta::with('user')
            ->when($search, fn ($q) => $q
                ->where(function ($sub) use ($search) {
                    $sub->where('nama_peserta', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('jurusan', 'like', "%{$search}%");
                })
            )->paginate(15)->withQueryString();
    }

    public function getPesertaBySesi(string $sesi, ?string $search = null)
    {
        Log::info('[PesertaService::getPesertaBySesi] Mengambil peserta by sesi', [
            'sesi' => $sesi,
            'search' => $search,
        ]);

        return Peserta::with('user')
            ->where('sesi', $sesi)
            ->when($search, fn ($q) => $q
                ->where(function ($sub) use ($search) {
                    $sub->where('nama_peserta', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('jurusan', 'like', "%{$search}%");
                })
            )->paginate(15)->withQueryString();
    }

    public function importPesertaExcel(Request $request): bool
    {
        Log::info('[PesertaService::importPesertaExcel] Memulai import Excel');

        try {
            Excel::import(new UserImport, $request->file('file'));
            Log::info('[PesertaService::importPesertaExcel] Import Excel berhasil');

            return true;
        } catch (\Throwable $th) {
            Log::error('[PesertaService::importPesertaExcel] Import Excel gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }


    public function updatePeserta(Request $request): bool
    {
        Log::info('[PesertaService::updatePeserta] Memulai update peserta', [
            'id_peserta' => $request->id_peserta,
        ]);

        $peserta = Peserta::find($request->id_peserta);
        $user    = $peserta?->user;

        // Validasi NIM selalu dijalankan
        $rules = [
            'nim' => 'min:10|max:10',
        ];

        $request->validate($rules, [
            'nim.max'      => 'NIM Must be 10 Numbers',
            'nim.min'      => 'NIM Must be 10 Numbers',
        ]);

        DB::beginTransaction();
        try {
            Peserta::where('id_peserta', $request->id_peserta)->update([
                'nama_peserta'   => $request->name,
                'nim'            => $request->nim,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'jurusan'        => $request->jurusan,
                'sesi'           => $request->sesi,
            ]);

            User::where('id', $user->id)->update([
                'name'  => $request->name,
            ]);

            DB::commit();

            Log::info('[PesertaService::updatePeserta] Update peserta berhasil', [
                'id_peserta' => $request->id_peserta,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('[PesertaService::updatePeserta] Update peserta gagal', [
                'id_peserta' => $request->id_peserta,
                'error'      => $th->getMessage(),
                'file'       => $th->getFile(),
                'line'       => $th->getLine(),
            ]);

            return false;
        }
    }

    public function deletePeserta(Request $request): bool
    {
        Log::info('[PesertaService::deletePeserta] Memulai hapus peserta', [
            'id_peserta' => $request->id_peserta,
            'id_users' => $request->id_users,
        ]);

        DB::beginTransaction();
        try {
            Peserta::where('id_peserta', $request->id_peserta)->delete();
            User::where('id', $request->id_users)->delete();
            DB::commit();
            Log::info('[PesertaService::deletePeserta] Hapus peserta berhasil', [
                'id_peserta' => $request->id_peserta,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PesertaService::deletePeserta] Hapus peserta gagal', [
                'id_peserta' => $request->id_peserta,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function deleteAllPeserta(string $sesi): bool
    {
        Log::info('[PesertaService::deleteAllPeserta] Memulai hapus semua peserta', [
            'sesi' => $sesi,
        ]);

        DB::beginTransaction();
        try {
            $pesertaList = Peserta::where('sesi', $sesi)->get();
            $userIds = $pesertaList->pluck('id_users')->toArray();

            Peserta::where('sesi', $sesi)->delete();
            User::whereIn('id', $userIds)->delete();

            DB::commit();

            Log::info('[PesertaService::deleteAllPeserta] Hapus semua peserta berhasil', [
                'sesi' => $sesi,
                'total' => count($pesertaList),
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('[PesertaService::deleteAllPeserta] Hapus semua peserta gagal', [
                'sesi' => $sesi,
                'error' => $th->getMessage(),
            ]);

            return false;
        }
    }

    public function resetStatusPeserta($id_peserta): bool
    {
        Log::info('[PesertaService::resetStatusPeserta] Memulai reset status peserta', [
            'id_peserta' => $id_peserta,
        ]);

        try {
            Peserta::where('id_peserta', $id_peserta)->update([
                'status'            => 'Belum',
                'pdf_status'        => 'Pending',
                'pdf_path'          => null,
                'benar_listening'   => 0,
                'benar_reading'     => 0,
                'skor_listening'    => 0,
                'skor_reading'      => 0,
                'listening_start_at'=> null,
                'reading_start_at'  => null,
            ]);

            Log::info('[PesertaService::resetStatusPeserta] Reset status peserta berhasil', [
                'id_peserta' => $id_peserta,
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[PesertaService::resetStatusPeserta] Reset status peserta gagal', [
                'id_peserta' => $id_peserta,
                'error'      => $th->getMessage(),
                'file'       => $th->getFile(),
                'line'       => $th->getLine(),
            ]);

            return false;
        }
    }

    public function resetAllStatusPeserta(string $sesi) {
        Peserta::where('sesi', $sesi)->update([
            'status'            => 'Belum',
            'pdf_status'        => 'Pending',
            'pdf_path'          => null,
            'benar_listening'   => 0,
            'benar_reading'     => 0,
            'skor_listening'    => 0,
            'skor_reading'      => 0,
            'listening_start_at'=> null,
            'reading_start_at'  => null,
        ]);
    }

    public function exportExcel(string $sesi)
    {
        Log::info('[PesertaService::exportExcel] Export Excel peserta', [
            'sesi' => $sesi,
        ]);

        return Excel::download(new PesertaExport($sesi), 'Data_Peserta_'.$sesi.'.xlsx');
    }

    public function resetPasswordPeserta($id_peserta) {
        $user = Peserta::findOrFail($id_peserta);

        $format_tgl = Carbon::parse($user->tanggal_lahir)->format('dmY');

        User::where('id', $user->id_users)->update([
            'password' => Hash::make($format_tgl),
            'is_password_changed' => false,
        ]);

        return true;
    }
}
