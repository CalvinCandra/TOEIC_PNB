<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\Peserta;
use App\Models\SelfStudyAttempt;
use App\Services\SelfStudy\SelfStudyService;
use Illuminate\Http\Request;

class SelfStudyHistoryController extends Controller
{
    public function __construct(protected SelfStudyService $service) {}

    private function viewPrefix(): string
    {
        return auth()->user()->level === 'admin' ? 'admin' : 'petugas';
    }

    private function routePrefix(): string
    {
        return auth()->user()->level === 'admin' ? 'Admin' : 'Petugas';
    }

    public function listPeserta(Request $request)
    {
        $filters = $request->only(['search']);

        $peserta = $this->service
            ->queryPesertaWithAttempts($filters)
            ->paginate(25)
            ->withQueryString();

        $routePrefix = $this->routePrefix();

        return view("{$this->viewPrefix()}.content.SelfStudyHistory.peserta",
            compact('peserta', 'filters', 'routePrefix'));
    }

    public function detailPeserta(int $idPeserta)
    {
        $peserta = Peserta::findOrFail($idPeserta);
        $banks = $this->service->getPesertaHistoryBanks($idPeserta);
        $routePrefix = $this->routePrefix();

        return view("{$this->viewPrefix()}.content.SelfStudyHistory.detail",
            compact('peserta', 'banks', 'routePrefix'))
            ->with('viewMode', 'banks');
    }

    public function detailBank(int $idPeserta, int $idBank)
    {
        $peserta = Peserta::findOrFail($idPeserta);
        $data = $this->service->getPesertaBankDetail($idPeserta, $idBank);
        $routePrefix = $this->routePrefix();

        return view("{$this->viewPrefix()}.content.SelfStudyHistory.detail",
            compact('peserta', 'routePrefix') + $data)
            ->with('viewMode', 'bank');
    }
}
