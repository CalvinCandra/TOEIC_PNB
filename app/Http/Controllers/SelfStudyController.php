<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\Part;
use App\Models\Peserta;
use App\Models\Soal;
use App\Services\SelfStudy\SelfStudyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class SelfStudyController extends Controller
{
    public function __construct(protected SelfStudyService $service) {}

    public function banks()
    {
        $peserta = Peserta::where('id_users', auth()->id())->firstOrFail();
        $banks = $this->service->getAvailableBanks($peserta->id_peserta);

        return view('peserta.SelfStudy.banks', compact('banks', 'peserta'));
    }

    public function parts(int $idBank)
    {
        $peserta = Peserta::where('id_users', auth()->id())->firstOrFail();
        $bank = BankSoal::forSelfStudy()->findOrFail($idBank);
        $parts = $this->service->getPartsInBank($peserta->id_peserta, $bank);

        return view('peserta.SelfStudy.parts', compact('bank', 'parts', 'peserta'));
    }

    public function latihan(int $idBank, string $tokenPart)
    {
        $peserta = Peserta::where('id_users', auth()->id())->firstOrFail();
        $bank = BankSoal::forSelfStudy()->findOrFail($idBank);
        $part = Part::where('token_part', $tokenPart)
            ->where('id_bank', $idBank)
            ->firstOrFail();

        if (! $this->service->canAccessPart($peserta->id_peserta, $bank, $part)) {
            Alert::warning('Locked', 'Please complete the previous part first.');
            return redirect("/SelfStudy/Bank/{$idBank}");
        }

        $soal = Soal::with(['audio', 'gambar'])
            ->where('kategori', $part->kategori)
            ->where('id_bank', $bank->id_bank)
            ->whereBetween('nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->orderBy('nomor_soal')
            ->get();

        return view('peserta.SelfStudy.latihan', compact('bank', 'part', 'soal', 'peserta'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'id_bank'      => 'required|exists:bank_soal,id_bank',
            'id_part'      => 'required|exists:part,id_part',
            'jawaban'      => 'array',
            'durasi_detik' => 'nullable|integer|min:0',
        ]);

        $peserta = Peserta::where('id_users', auth()->id())->firstOrFail();
        $bank = BankSoal::forSelfStudy()->findOrFail($request->id_bank);
        $part = Part::where('id_part', $request->id_part)
            ->where('id_bank', $request->id_bank)
            ->firstOrFail();

        if (! $this->service->canAccessPart($peserta->id_peserta, $bank, $part)) {
            Alert::error('Forbidden', 'You cannot submit this part yet.');
            return redirect("/SelfStudy/Bank/{$bank->id_bank}");
        }

        $attempt = $this->service->submitAttempt(
            $peserta->id_peserta,
            $bank,
            $part,
            $request->jawaban ?? [],
            $request->durasi_detik ? (int) $request->durasi_detik : null
        );

        // Grade and save session analysis detail
        $soalList = Soal::where('kategori', $part->kategori)
            ->where('id_bank', $part->id_bank)
            ->whereBetween('nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->orderBy('nomor_soal')
            ->get();

        $jawabanPeserta = $request->jawaban ?? [];
        $analysis = [];
        foreach ($soalList as $soal) {
            $userAns = $jawabanPeserta[$soal->id_soal] ?? null;
            $isCorrect = ($userAns !== null && strtoupper($userAns) === strtoupper($soal->kunci_jawaban));
            $analysis[$soal->id_soal] = [
                'nomor_soal' => $soal->nomor_soal,
                'user_answer' => $userAns,
                'is_correct' => $isCorrect,
            ];
        }
        session()->put("self_study_analysis_{$part->id_part}", $analysis);

        Log::info('[SelfStudyController::submit]', [
            'id_peserta' => $peserta->id_peserta,
            'id_bank'    => $bank->id_bank,
            'id_part'    => $part->id_part,
            'skor'       => $attempt->skor,
        ]);

        return redirect("/SelfStudy/Bank/{$bank->id_bank}/Part/{$part->token_part}/Result");
    }

    public function result(int $idBank, string $tokenPart)
    {
        $peserta = Peserta::where('id_users', auth()->id())->firstOrFail();
        $bank = BankSoal::forSelfStudy()->findOrFail($idBank);
        $part = Part::where('token_part', $tokenPart)
            ->where('id_bank', $idBank)
            ->firstOrFail();

        $chartData = $this->service->getPartProgressChart(
            $peserta->id_peserta, $bank->id_bank, $part->id_part
        );

        if ($chartData['total'] === 0) {
            Alert::info('No Data', 'You have not attempted this part yet.');
            return redirect("/SelfStudy/Bank/{$idBank}");
        }

        $soal = Soal::with(['audio', 'gambar'])
            ->where('kategori', $part->kategori)
            ->where('id_bank', $bank->id_bank)
            ->whereBetween('nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->orderBy('nomor_soal')
            ->get();

        $analysis = session()->get("self_study_analysis_{$part->id_part}");

        return view('peserta.SelfStudy.result', compact('bank', 'part', 'chartData', 'peserta', 'soal', 'analysis'));
    }

    public function review(int $idBank)
    {
        $peserta = Peserta::where('id_users', auth()->id())->firstOrFail();
        $bank = BankSoal::forSelfStudy()->findOrFail($idBank);

        $detail = $this->service->getPesertaBankDetail($peserta->id_peserta, $idBank);

        return view('peserta.SelfStudy.review', [
            'bank'                => $detail['bank'],
            'parts_data'          => $detail['parts_data'],
            'overall_chart'       => $detail['overall_chart'],
            'total_average_score' => $detail['total_average_score'],
            'total_parts'         => $detail['total_parts'],
            'peserta'             => $peserta,
        ]);
    }
}
