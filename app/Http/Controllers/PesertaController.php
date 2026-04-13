<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\Peserta;
use App\Services\Peserta\PesertaProfilService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class PesertaController extends Controller
{
    public function __construct(protected PesertaProfilService $profilService) {}

    public function index()
    {
        return view('peserta.content.dashboard');
    }

    public function Profil()
    {
        $peserta = $this->profilService->getPeserta(auth()->id());

        return view('peserta.content.profil', compact('peserta'));
    }

    public function UpdateProfil(Request $request)
    {
        $result = $this->profilService->updateProfil($request, auth()->id());

        if ($result === true) {
            toast('Update Profile Successful!', 'success');
        } elseif (is_string($result)) {
            return redirect()->back()->withErrors($result);
        } else {
            toast('Something Went Wrong!', 'error');
        }

        return redirect()->back();
    }

    public function DownloadResutl(Request $request)
    {
        $response = $this->profilService->downloadResult(auth()->id());

        if (! $response) {
            Alert::info('Information', 'Result file not found');

            return redirect('/Profil');
        }

        return $response;
    }

    public function ResetPasswordPage()
    {
        return view('peserta.content.resetPassword');
    }

    public function ResetPassword(Request $request)
    {
        $result = $this->profilService->resetPassword($request, auth()->id());

        if ($result === true) {
            toast('Password Reset Successful!', 'success');
            
            // PENTING: Jika berhasil, lempar ke halaman utama/dashboard, jangan back()
            return redirect('/peserta'); 
            
        } elseif (is_string($result)) {
            // Menampilkan error string (contoh: Old password is incorrect)
            toast($result, 'error');
            
            // withErrors akan melempar pesan ke variabel $errors di Blade
            return redirect()->back()->withErrors(['password_old' => $result]);
            
        } else {
            toast('Something Went Wrong!', 'error');
            return redirect()->back();
        }
    }

    public function dashSoal()
    {
        return view('peserta.content.dashSoal');
    }

    public function TokenQuestion(Request $request)
    {
        Log::info('[PesertaController::TokenQuestion] Peserta input token ujian', [
            'id_users' => auth()->id(),
            'bank_token_prefix' => substr($request->bankSoal ?? '', 0, 3).'***',
        ]);

        $cekBank = BankSoal::where('bank', $request->bankSoal)->first();
        $peserta = Peserta::where('id_users', auth()->id())->first();

        if (! $cekBank) {
            Log::warning('[PesertaController::TokenQuestion] Token tidak valid', ['id_users' => auth()->id()]);
            Alert::error('Failed', 'Token Question Not Work');

            return redirect('/DashboardSoal');
        }

        if (in_array($peserta->status, ['Sudah', 'Kerjain'])) {
            Log::warning('[PesertaController::TokenQuestion] Peserta sudah mengerjakan', [
                'id_peserta' => $peserta->id_peserta,
                'status' => $peserta->status,
            ]);
            Alert::info('Information', 'You have previously done the questions');

            return redirect('/DashboardSoal');
        }

        if ($cekBank->sesi_bank !== $peserta->sesi) {
            Log::warning('[PesertaController::TokenQuestion] Sesi tidak cocok', [
                'sesi_peserta' => $peserta->sesi,
                'sesi_bank' => $cekBank->sesi_bank,
            ]);
            Alert::info('Information', 'Please wait your turn for the session');

            return redirect('/DashboardSoal');
        }

        $now = Carbon::now('Asia/Singapore');
        $waktuMulai = Carbon::parse($cekBank->waktu_mulai)->setDate($now->year, $now->month, $now->day);
        $waktuAkhir = Carbon::parse($cekBank->waktu_akhir)->setDate($now->year, $now->month, $now->day);

        if ($now->lt($waktuMulai) || $now->gt($waktuAkhir)) {
            Log::warning('[PesertaController::TokenQuestion] Diakses di luar waktu', [
                'id_peserta' => $peserta->id_peserta,
                'waktu_mulai' => $cekBank->waktu_mulai,
                'waktu_akhir' => $cekBank->waktu_akhir,
            ]);
            Alert::info('Information', 'Token cannot be accessed due to timeout');

            return redirect('/DashboardSoal');
        }

        Log::info('[PesertaController::TokenQuestion] Token valid, redirect ke listening', [
            'id_peserta' => $peserta->id_peserta,
            'sesi' => $peserta->sesi,
        ]);

        $request->session()->put('bank', $cekBank->bank);

        return redirect('/Listening');
    }
}
