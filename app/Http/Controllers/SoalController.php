<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\soal;
use App\Services\Exam\UjianService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    private function setNavToken(Request $request, string $token, int $ttl = 30): void
    {
        $request->session()->put('exam_nav_token', $token);
        $request->session()->put('exam_nav_expiry', time() + $ttl);
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

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());
        $bank    = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $bank) {
            Log::warning('[SoalController::GetListening] Bank soal tidak ditemukan');

            return redirect('/DashboardSoal');
        }

        if ($peserta && is_null($peserta->listening_start_at)) {
            $peserta->update(['listening_start_at' => now()]);
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

        $this->setNavToken($request, $partPertama->token_part);

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

        $urlpathimage = Storage::disk('s3')->url('gambar/');
        $urlpathaudio = Storage::disk('s3')->url('audio/');

        return view('peserta.Soal.Listeningtest', compact('soalListening', 'part', 'GetAllPart', 'urlpathimage', 'urlpathaudio'))
            ->with('type', 'listening');
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

            $this->setNavToken($request, $nextPart->token_part);

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

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());
        $bank    = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $bank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');

            return redirect('/DashboardSoal');
        }

        if ($peserta && is_null($peserta->reading_start_at)) {
            $peserta->update(['reading_start_at' => now()]);
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

        $this->setNavToken($request, $partPertama->token_part);

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

        $urlpathimage = Storage::disk('s3')->url('gambar/');

        return view('peserta.Soal.Readingtest', compact('soalReading', 'part', 'GetAllPart', 'urlpathimage'))
            ->with('type', 'reading');
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

            $this->setNavToken($request, $nextPart->token_part);

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

    public function getRemainingTime(string $type)
    {
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if (!$peserta) {
            return response()->json(['remaining' => 0, 'auto_submit' => true]);
        }

        $durasiDetik = $type === 'listening' ? (46 * 60) : (75 * 60);

        $startAt = $type === 'listening'
            ? $peserta->listening_start_at
            : $peserta->reading_start_at;

        if (!$startAt) {
            return response()->json([
                'remaining'   => $durasiDetik,
                'auto_submit' => false,
            ]);
        }

        $elapsed   = now()->diffInSeconds($startAt);
        $remaining = max(0, $durasiDetik - $elapsed);

        return response()->json([
            'remaining'   => (int) $remaining,
            'auto_submit' => $remaining <= 0,
        ]);
    }

    public function leaveExam(Request $request)
    {
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if (!$peserta) {
            return response()->json(['success' => false], 404);
        }

        $this->ujianService->leaveExam($peserta);
        $this->clearExamSession($request);

        return response()->json(['success' => true]);
    }
}
