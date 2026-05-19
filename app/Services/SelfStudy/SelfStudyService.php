<?php

namespace App\Services\SelfStudy;

use App\Models\BankSoal;
use App\Models\Part;
use App\Models\SelfStudyAttempt;
use App\Models\Soal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SelfStudyService
{
    /* ============================================
     *  PESERTA-SIDE METHODS
     * ============================================ */

    public function getAvailableBanks(int $idPeserta): Collection
    {
        $banks = BankSoal::forSelfStudy()->orderBy('bank')->get();

        $stats = SelfStudyAttempt::where('id_peserta', $idPeserta)
            ->select(
                'id_bank',
                DB::raw('COUNT(DISTINCT id_part) as parts_done'),
                DB::raw('COUNT(*) as total_attempts'),
                DB::raw('MAX(skor) as best_skor')
            )
            ->groupBy('id_bank')
            ->get()
            ->keyBy('id_bank');

        return $banks->map(function ($bank) use ($stats) {
            $totalParts = Part::where('id_bank', $bank->id_bank)->count();
            $bank->total_parts    = $totalParts;
            $bank->parts_done     = $stats[$bank->id_bank]->parts_done ?? 0;
            $bank->total_attempts = $stats[$bank->id_bank]->total_attempts ?? 0;
            $bank->best_skor      = $stats[$bank->id_bank]->best_skor ?? null;
            $bank->progress_pct   = $totalParts > 0
                ? round(($bank->parts_done / $totalParts) * 100)
                : 0;
            return $bank;
        });
    }

    public function getPartsInBank(int $idPeserta, BankSoal $bank): Collection
    {
        $parts = Part::where('id_bank', $bank->id_bank)
            ->orderBy('tanda')
            ->get();

        // Daftar 'tanda' Part yang sudah pernah dikerjakan peserta di bank ini
        $completedTanda = SelfStudyAttempt::query()
            ->where('self_study_attempts.id_peserta', $idPeserta)
            ->where('self_study_attempts.id_bank', $bank->id_bank)
            ->join('part', 'part.id_part', '=', 'self_study_attempts.id_part')
            ->pluck('part.tanda')
            ->map(fn ($v) => (int) $v)
            ->unique()
            ->values()
            ->toArray();

        $stats = SelfStudyAttempt::where('id_peserta', $idPeserta)
            ->where('id_bank', $bank->id_bank)
            ->select(
                'id_part',
                DB::raw('MAX(skor) as best_skor'),
                DB::raw('COUNT(*) as total_attempts'),
                DB::raw('MIN(id_attempt) as first_attempt_id')
            )
            ->groupBy('id_part')
            ->get()
            ->keyBy('id_part');

        $firstScores = [];
        if ($stats->isNotEmpty()) {
            $firstAttemptIds = $stats->pluck('first_attempt_id')->filter()->toArray();
            $firstScores = SelfStudyAttempt::whereIn('id_attempt', $firstAttemptIds)
                ->pluck('skor', 'id_part')
                ->toArray();
        }

        // Build sequence list (tanda yang sebenarnya ada di bank ini)
        $existingTanda = $parts->pluck('tanda')->map(fn($v) => (int) $v)->sort()->values()->toArray();

        return $parts->map(function ($part) use ($completedTanda, $stats, $firstScores, $existingTanda) {
            $tanda = (int) $part->tanda;

            // Cari posisi Part ini di sequence
            $index = array_search($tanda, $existingTanda);
            $isFirst = $index === 0;

            // Cari tanda Part sebelumnya di sequence (bukan tanda - 1, tapi previous yang ADA)
            $prevTanda = $index > 0 ? $existingTanda[$index - 1] : null;
            $prevDone = $prevTanda !== null && in_array($prevTanda, $completedTanda, true);

            $part->is_unlocked    = $isFirst || $prevDone;
            $part->is_completed   = in_array($tanda, $completedTanda, true);
            $part->best_skor      = $stats[$part->id_part]->best_skor ?? null;
            $part->first_skor     = $firstScores[$part->id_part] ?? null;
            $part->total_attempts = $stats[$part->id_part]->total_attempts ?? 0;
            return $part;
        });
    }

    public function canAccessPart(int $idPeserta, BankSoal $bank, Part $part): bool
    {
        if ($part->id_bank !== $bank->id_bank) {
            return false;
        }

        // Build existing tanda sequence
        $existingTanda = Part::where('id_bank', $bank->id_bank)
            ->orderBy('tanda')
            ->pluck('tanda')
            ->map(fn($v) => (int) $v)
            ->toArray();

        $currentTanda = (int) $part->tanda;
        $index = array_search($currentTanda, $existingTanda);

        // Part pertama di sequence selalu accessible
        if ($index === 0) {
            return true;
        }

        if ($index === false) {
            return false;
        }

        // Cek Part sebelumnya (di sequence ini) sudah di-attempt
        $prevTanda = $existingTanda[$index - 1];

        return SelfStudyAttempt::where('id_peserta', $idPeserta)
            ->where('id_bank', $bank->id_bank)
            ->whereHas('part', fn ($q) => $q->where('tanda', $prevTanda))
            ->exists();
    }

    public function submitAttempt(
        int $idPeserta,
        BankSoal $bank,
        Part $part,
        array $jawaban,
        ?int $durasiDetik = null
    ): SelfStudyAttempt {
        return DB::transaction(function () use ($idPeserta, $bank, $part, $jawaban, $durasiDetik) {

            // Query soal pakai range nomor_soal + kategori + id_bank
            // BUKAN id_part (kolom tidak ada di tabel soal)
            $soalList = Soal::where('kategori', $part->kategori)
                ->where('id_bank', $part->id_bank)
                ->whereBetween('nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
                ->orderBy('nomor_soal')
                ->get();

            $totalSoal = $soalList->count();

            $benar = 0;
            $salah = 0;
            foreach ($soalList as $soal) {
                $jawabanPeserta = $jawaban[$soal->id_soal] ?? 'N';
                $jawabanPeserta === $soal->kunci_jawaban ? $benar++ : $salah++;
            }

            $skor = $totalSoal > 0
                ? (int) round(($benar / $totalSoal) * 100)
                : 0;

            $attemptNumber = (SelfStudyAttempt::where('id_peserta', $idPeserta)
                ->where('id_bank', $bank->id_bank)
                ->where('id_part', $part->id_part)
                ->max('attempt_number') ?? 0) + 1;

            $attempt = SelfStudyAttempt::create([
                'id_peserta'     => $idPeserta,
                'id_bank'        => $bank->id_bank,
                'id_part'        => $part->id_part,
                'attempt_number' => $attemptNumber,
                'jumlah_benar'   => $benar,
                'jumlah_salah'   => $salah,
                'skor'           => $skor,
                'durasi_detik'   => $durasiDetik,
            ]);

            Log::info('[SelfStudyService::submitAttempt] Attempt saved', [
                'id_peserta'     => $idPeserta,
                'id_bank'        => $bank->id_bank,
                'id_part'        => $part->id_part,
                'attempt_number' => $attemptNumber,
                'benar'          => $benar,
                'total_soal'     => $totalSoal,
                'skor_persen'    => $skor,
            ]);

            return $attempt;
        });
    }

    public function getPartProgressChart(int $idPeserta, int $idBank, int $idPart): array
    {
        $attempts = SelfStudyAttempt::where('id_peserta', $idPeserta)
            ->where('id_bank', $idBank)
            ->where('id_part', $idPart)
            ->orderBy('attempt_number')
            ->get(['attempt_number', 'skor', 'jumlah_benar', 'created_at']);

        return [
            'labels' => $attempts->pluck('attempt_number')->map(fn ($n) => "Attempt #{$n}")->toArray(),
            'data'   => $attempts->pluck('skor')->toArray(),
            'first'  => (int) ($attempts->first()->skor ?? 0),
            'best'   => (int) ($attempts->max('skor') ?? 0),
            'last'   => (int) ($attempts->last()->skor ?? 0),
            'avg'    => $attempts->count() ? (int) round($attempts->avg('skor')) : 0,
            'total'  => $attempts->count(),
        ];
    }

    public function getOverallChart(int $idPeserta, int $idBank): array
    {
        $rounds = SelfStudyAttempt::where('id_peserta', $idPeserta)
            ->where('id_bank', $idBank)
            ->select(
                'attempt_number',
                DB::raw('AVG(skor) as avg_skor'),
                DB::raw('COUNT(*) as parts_count')
            )
            ->groupBy('attempt_number')
            ->orderBy('attempt_number')
            ->get();

        return [
            'labels'      => $rounds->pluck('attempt_number')->map(fn ($n) => "Round #{$n}")->toArray(),
            'data'        => $rounds->pluck('avg_skor')->map(fn ($v) => (int) round($v))->toArray(),
            'parts_count' => $rounds->pluck('parts_count')->toArray(),
            'best_avg'    => $rounds->count() ? (int) round($rounds->max('avg_skor')) : 0,
            'last_avg'    => $rounds->count() ? (int) round($rounds->last()->avg_skor) : 0,
            'total_rounds' => $rounds->count(),
        ];
    }

    /* ============================================
     *  ADMIN/PETUGAS HISTORY METHODS
     * ============================================ */

    public function queryAttemptsForAdmin(array $filters = [])
    {
        $query = SelfStudyAttempt::query()
            ->with([
                'peserta:id_peserta,nama_peserta,nim',
                'bank:id_bank,bank,sesi_bank,mode',
                'part:id_part,part,kategori,id_bank',
            ])
            ->latest('id_attempt');

        if (! empty($filters['id_bank'])) {
            $query->where('id_bank', $filters['id_bank']);
        }

        if (! empty($filters['kategori'])) {
            $query->whereHas('part', fn ($q) => $q->where('kategori', $filters['kategori']));
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('peserta', function ($q) use ($search) {
                $q->where('nama_peserta', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function queryPesertaWithAttempts(array $filters = [])
    {
        $query = \App\Models\Peserta::query()
            ->select([
                'peserta.id_peserta',
                'peserta.nim',
                'peserta.nama_peserta',
                DB::raw('COUNT(DISTINCT self_study_attempts.id_bank) as total_banks'),
                DB::raw('COUNT(self_study_attempts.id_attempt) as total_attempts'),
                DB::raw('MAX(self_study_attempts.skor) as best_skor'),
                DB::raw('MAX(self_study_attempts.created_at) as last_activity'),
            ])
            ->join('self_study_attempts', 'self_study_attempts.id_peserta', '=', 'peserta.id_peserta')
            ->groupBy('peserta.id_peserta', 'peserta.nim', 'peserta.nama_peserta')
            ->orderByDesc('last_activity');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('peserta.nama_peserta', 'like', "%{$search}%")
                  ->orWhere('peserta.nim', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function getPesertaHistoryBanks(int $idPeserta): Collection
    {
        return SelfStudyAttempt::where('id_peserta', $idPeserta)
            ->select([
                'id_bank',
                DB::raw('COUNT(DISTINCT id_part) as parts_done'),
                DB::raw('COUNT(*) as total_attempts'),
                DB::raw('MAX(skor) as best_skor'),
                DB::raw('MIN(created_at) as first_activity'),
                DB::raw('MAX(created_at) as last_activity'),
            ])
            ->with('bank:id_bank,bank,sesi_bank,mode')
            ->groupBy('id_bank')
            ->orderByDesc('last_activity')
            ->get();
    }

    public function getPesertaBankDetail(int $idPeserta, int $idBank): array
    {
        $bank = BankSoal::findOrFail($idBank);

        $parts = Part::where('id_bank', $idBank)
            ->orderBy('tanda')
            ->get();

        $attempts = SelfStudyAttempt::where('id_peserta', $idPeserta)
            ->where('id_bank', $idBank)
            ->orderBy('id_part')
            ->orderBy('attempt_number')
            ->get();

        $byPart = $attempts->groupBy('id_part');

        $partsData = $parts->map(function ($part) use ($byPart) {
            $partAttempts = $byPart->get($part->id_part, collect());
            $part->all_attempts = $partAttempts;
            $part->first_skor   = $partAttempts->first()?->skor;
            $part->last_skor    = $partAttempts->last()?->skor;
            $part->best_skor    = $partAttempts->max('skor');
            $part->total        = $partAttempts->count();
            return $part;
        });

        $overallChart = $this->getOverallChart($idPeserta, $idBank);

        return [
            'bank'         => $bank,
            'parts_data'   => $partsData,
            'overall_chart' => $overallChart,
        ];
    }
}
