<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\soal;
use App\Services\Exam\UjianService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class SoalController extends Controller
{
    public function __construct(protected UjianService $ujianService) {}

    private function guardSession(Request $request): bool
    {
        return $request->session()->get('bank') !== null;
    }

    private function clearExamSession(Request $request): void
    {
        $request->session()->forget(['bank', 'waktu', 'quizEndTime']);
    }

    // ============================================================
    // LISTENING
    // ============================================================

    public function Listening(Request $request)
    {
        Log::info('[SoalController::Listening] Masuk halaman aturan listening', ['id_users' => auth()->id()]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        return view('peserta.Soal.ListeningAturan');
    }

    public function GetListening(Request $request)
    {
        Log::info('[SoalController::GetListening] Peserta mulai listening', ['id_users' => auth()->id()]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            Log::warning('[SoalController::GetListening] Bank soal tidak ditemukan');

            return redirect('/DashboardSoal');
        }

        $quizEndTime = Carbon::now()->addMinutes(45);
        $request->session()->put('quizEndTime', $quizEndTime);
        $request->session()->put('waktu_akhir', Carbon::today()->format('Y-m-d').' '.$getBank->waktu_akhir);

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());
        $peserta->update(['status' => 'Kerjain']);

        $partPertama = Part::where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->first();

        Log::info('[SoalController::GetListening] Redirect ke part pertama', [
            'id_peserta' => $peserta->id_peserta,
            'token_part' => $partPertama->token_part,
        ]);

        return redirect("/SoalListening/{$partPertama->token_part}");
    }

    public function soalListening(Request $request, string $token)
    {
        Log::info('[SoalController::soalListening] Tampil soal listening', [
            'id_users' => auth()->id(),
            'token_part' => $token,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));
        $part = Part::with(['audio', 'gambar'])->where('kategori', 'Listening')->where('token_part', $token)->first();
        $GetAllPart = Part::where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->get();

        $soalListening = soal::with('audio', 'gambar')
            ->join('bank_soal', 'bank_soal.id_bank', '=', 'soal.id_bank')
            ->join('part', 'part.id_bank', '=', 'bank_soal.id_bank')
            ->where('part.kategori', 'Listening')
            ->where('soal.kategori', 'Listening')
            ->where('part.token_part', $token)
            ->where('part.id_bank', $getBank->id_bank)
            ->whereBetween('soal.nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->select('soal.*')
            ->get();

        $remainingTime = Carbon::now()->diffInSeconds($request->session()->get('quizEndTime'));
        $request->session()->put('waktu', $remainingTime);

        return view('peserta.Soal.Listeningtest', compact('soalListening', 'part', 'GetAllPart'));
    }

    public function ProsesJawabListening(Request $request)
    {
        Log::info('[SoalController::ProsesJawabListening] Proses jawaban listening', [
            'id_users' => auth()->id(),
            'jumlah_soal' => count($request->id_soal ?? []),
            'tombol' => $request->tombol,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }
        if (! $request->isMethod('post')) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');

            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        try {
            $this->ujianService->simpanJawaban($peserta->id_peserta, $request->id_soal, $request->jawaban ?? []);
        } catch (\Throwable $th) {
            Log::error('[SoalController::ProsesJawabListening] Gagal simpan jawaban', ['error' => $th->getMessage()]);
        }

        if ($request->tombol === 'next') {
            $nextPart = $this->ujianService->getNextPart((int) $request->id_part, $getBank->id_bank, 'Listening');

            return redirect("/SoalListening/{$nextPart->token_part}");
        }

        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect()->route('nilaiListening');
    }

    public function GetNilaiListening(Request $request)
    {
        Log::info('[SoalController::GetNilaiListening] Hitung nilai listening', ['id_users' => auth()->id()]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');

            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());
        $hasil = $this->ujianService->hitungSkorListening($peserta, $getBank);

        $request->session()->put('benarListening', $hasil['benar']);
        $request->session()->put('salahListening', $hasil['salah']);
        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect('/Reading');
    }

    // ============================================================
    // READING
    // ============================================================

    public function Reading(Request $request)
    {
        Log::info('[SoalController::Reading] Masuk halaman aturan reading', ['id_users' => auth()->id()]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        return view('peserta.Soal.ReadingAturan');
    }

    public function GetReading(Request $request)
    {
        Log::info('[SoalController::GetReading] Peserta mulai reading', ['id_users' => auth()->id()]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');

            return redirect('/DashboardSoal');
        }

        $quizEndTime = Carbon::now()->addMinutes(75);
        $request->session()->put('quizEndTime', $quizEndTime);
        $request->session()->put('waktu_akhir', Carbon::today()->format('Y-m-d').' '.$getBank->waktu_akhir);

        $partPertama = Part::where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->first();

        return redirect("/SoalReading/{$partPertama->token_part}");
    }

    public function soalReading(Request $request, string $token)
    {
        Log::info('[SoalController::soalReading] Tampil soal reading', [
            'id_users' => auth()->id(),
            'token_part' => $token,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');

            return redirect('/DashboardSoal');
        }

        $part = Part::with(['audio', 'gambar', 'gambar1', 'gambar2'])->where('kategori', 'Reading')->where('token_part', $token)->first();
        $GetAllPart = Part::where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->get();

        $soalReading = soal::with('audio', 'gambar', 'gambar1', 'gambar2')
            ->join('bank_soal', 'bank_soal.id_bank', '=', 'soal.id_bank')
            ->join('part', 'part.id_bank', '=', 'bank_soal.id_bank')
            ->where('part.kategori', 'Reading')
            ->where('soal.kategori', 'Reading')
            ->where('part.token_part', $token)
            ->where('part.id_bank', $getBank->id_bank)
            ->whereBetween('soal.nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->select('soal.*')
            ->get();

        $remainingTime = Carbon::now()->diffInSeconds($request->session()->get('quizEndTime'));
        $request->session()->put('waktu', $remainingTime);

        return view('peserta.Soal.Readingtest', compact('soalReading', 'part', 'GetAllPart'));
    }

    public function ProsesJawabReading(Request $request)
    {
        Log::info('[SoalController::ProsesJawabReading] Proses jawaban reading', [
            'id_users' => auth()->id(),
            'jumlah_soal' => count($request->id_soal ?? []),
            'tombol' => $request->tombol,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }
        if (! $request->isMethod('post')) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');

            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        try {
            $this->ujianService->simpanJawaban($peserta->id_peserta, $request->id_soal, $request->jawaban ?? []);
        } catch (\Throwable $th) {
            Log::error('[SoalController::ProsesJawabReading] Gagal simpan jawaban', ['error' => $th->getMessage()]);
        }

        if ($request->tombol === 'next') {
            $nextPart = $this->ujianService->getNextPart((int) $request->id_part, $getBank->id_bank, 'Reading');

            return redirect("/SoalReading/{$nextPart->token_part}");
        }

        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect()->route('nilaiReading');
    }

    public function GetNilaiReading(Request $request)
    {
        Log::info('[SoalController::GetNilaiReading] Hitung nilai reading', ['id_users' => auth()->id()]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');

            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());
        $hasil = $this->ujianService->hitungSkorReading($peserta, $getBank);

        $request->session()->put('benarReading', $hasil['benar']);
        $request->session()->put('salahReading', $hasil['salah']);
        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect('/Result');
    }

    public function destory(Request $request)
    {
        $request->session()->forget([
            'benarReading', 'salahReading',
            'benarListening', 'salahListening',
            'bank', 'email_sent', 'result_generated', 'quizEndTime',
        ]);

        return redirect('/DashboardSoal');
    }
}
