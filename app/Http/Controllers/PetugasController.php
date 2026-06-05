<?php

namespace App\Http\Controllers;

use App\Services\Media\MediaService;
use App\Services\Part\PartService;
use App\Services\Peserta\PesertaService;
use App\Services\Soal\BankSoalService;
use App\Services\Soal\SoalCrudService;
use App\Services\TemplateExcelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    public function __construct(
        protected PesertaService $pesertaService,
        protected SoalCrudService $soalService,
        protected BankSoalService $bankSoalService,
        protected PartService $partService,
        protected MediaService $mediaService,
        protected TemplateExcelService $templateExcelService,
    ) {}

    public function index()
    {
        $data = DB::table('peserta')
            ->select('sesi', 'status', DB::raw('COUNT(*) as total'))
            ->whereNotNull('sesi')
            ->groupBy('sesi', 'status')
            ->orderBy('sesi')
            ->get();

        $sessions = $data->pluck('sesi')->unique()->sort()->values();

        $statuses = ['Sudah', 'Kerjain', 'Belum'];

        $allChartData = [];
        foreach ($sessions as $sesi) {
            $allChartData[$sesi] = [
                'sesi' => $sesi,
                'data' => [
                    'Done' => $data->where('sesi', $sesi)->where('status', 'Sudah')->sum('total') ?? 0,
                    'Work' => $data->where('sesi', $sesi)->where('status', 'Kerjain')->sum('total') ?? 0,
                    'Not Yet' => $data->where('sesi', $sesi)->where('status', 'Belum')->sum('total') ?? 0,
                ],
                'total' => $data->where('sesi', $sesi)->sum('total'),
            ];
        }

        $allJurusanData = [];
        foreach ($sessions as $sesi) {
            $jurusanData = DB::table('peserta')
                ->select('jurusan', 'status', DB::raw('COUNT(*) as total'))
                ->where('sesi', $sesi)
                ->groupBy('jurusan', 'status')
                ->orderBy('jurusan')
                ->get();

            $jurusanList = $jurusanData->pluck('jurusan')->unique()->sort()->values();
            $chartData = [];
            foreach ($jurusanList as $j) {
                $chartData[] = [
                    'jurusan' => $j,
                    'data' => [
                        'Done' => $jurusanData->where('jurusan', $j)->where('status', 'Sudah')->sum('total') ?? 0,
                        'Work' => $jurusanData->where('jurusan', $j)->where('status', 'Kerjain')->sum('total') ?? 0,
                        'Not Yet' => $jurusanData->where('jurusan', $j)->where('status', 'Belum')->sum('total') ?? 0,
                    ],
                    'total' => $jurusanData->where('jurusan', $j)->sum('total'),
                ];
            }
            $allJurusanData[$sesi] = $chartData;
        }

        $allTopScorers = [];
        foreach ($sessions as $sesi) {
            $allTopScorers[$sesi] = \App\Models\Peserta::with('user')
                ->where('sesi', $sesi)
                ->where('status', 'Sudah')
                ->orderByRaw('(skor_listening + skor_reading) DESC')
                ->take(5)
                ->get();
        }

        return view('petugas.content.dashboard', compact('sessions', 'statuses', 'allChartData', 'allJurusanData', 'allTopScorers'));
    }

    public function dashPetugasPeserta()
    {
        $peserta = $this->pesertaService->getPesertaAll(request('search'));

        return view('petugas.content.Peserta.PetugasPeserta', compact('peserta'));
    }

    public function dashPetugasPeserta1()
    {
        $peserta = $this->pesertaService->getPesertaBySesi('Session 1', request('search'));

        return view('petugas.content.Peserta.PetugasPeserta1', compact('peserta'));
    }

    public function dashPetugasPeserta2()
    {
        $peserta = $this->pesertaService->getPesertaBySesi('Session 2', request('search'));

        return view('petugas.content.Peserta.PetugasPeserta2', compact('peserta'));
    }

    public function dashPetugasPeserta3()
    {
        $peserta = $this->pesertaService->getPesertaBySesi('Session 3', request('search'));

        return view('petugas.content.Peserta.PetugasPeserta3', compact('peserta'));
    }

    public function TambahPesertaExcel(Request $request)
    {
        $this->pesertaService->importPesertaExcel($request)
            ? toast('Import Berhasil', 'success')
            : toast('Import Gagal', 'error');

        return redirect()->back();
    }

    public function UpdatePetugasPeserta(Request $request)
    {
        $this->pesertaService->updatePeserta($request)
            ? toast('Peserta Berhasil Diupdate', 'success')
            : toast('Gagal Update Peserta', 'error');

        return redirect()->back();
    }

    public function DeletePetugasPeserta(Request $request)
    {
        $this->pesertaService->deletePeserta($request)
            ? toast('Peserta Berhasil Dihapus', 'success')
            : toast('Gagal Hapus Peserta', 'error');

        return redirect()->back();
    }

    public function DeletePetugasAllPeserta($sesi)
    {
        $sesiTran = match($sesi) {
            'Sesione' => 'Session 1',
            'Sesitwo' => 'Session 2',
            'Sesithree' => 'Session 3',
            default => null,
        };
        $this->pesertaService->deleteAllPeserta($sesiTran);
        toast('Semua Peserta Dihapus', 'success');

        return redirect()->back();
    }

    public function UpdateStatusPeserta($id)
    {
        $this->pesertaService->resetStatusPeserta($id)
            ? toast('Status Peserta Berhasil Direset', 'success')
            : toast('Gagal Reset Status Peserta', 'error');

        return redirect()->back();
    }

    public function ResetAllStatusPeserta($sesi)
    {
        $this->pesertaService->resetAllStatusPeserta($sesi);
        toast('Status Semua Peserta Direset', 'success');

        return redirect()->back();
    }

    public function ExportExcelPetugas($sesi)
    {
        return $this->pesertaService->exportExcel($sesi);
    }

    public function dashPetugasSoal()
    {
        $bank = $this->bankSoalService->getBankSoalAll();

        return view('petugas.content.BankSoal.dashbanksoal', compact('bank'));
    }

    public function TambahBankSoal(Request $request)
    {
        $this->bankSoalService->storeBankSoal($request)
            ? toast('Bank Soal Ditambah', 'success')
            : toast('Gagal', 'error');

        return redirect()->back();
    }

    public function UpdateBankSoal(Request $request)
    {
        $this->bankSoalService->updateBankSoal($request)
            ? toast('Bank Soal Diupdate', 'success')
            : toast('Gagal', 'error');

        return redirect()->back();
    }

    public function DeleteBankSoal(Request $request)
    {
        $this->bankSoalService->deleteBankSoal($request->id_bank)
            ? toast('Bank Soal  Dihapus', 'success')
            : toast('Gagal', 'error');

        return redirect()->back();
    }

    public function dashPetugasGambar()
    {
        $gambar = $this->mediaService->getGambarAll();

        $urlpathimage = Storage::disk('s3')->url('gambar/');

        return view('petugas.content.Gambar.gambarPetugas', compact('gambar', 'urlpathimage'));
    }

    public function TambahGambar(Request $request)
    {
        $this->mediaService->storeGambar($request)
            ? toast('Gambar Berhasil Diupload', 'success')
            : toast('Gagal Upload Gambar', 'error');

        return redirect()->back();
    }

    public function DeleteGambar(Request $request)
    {
        $this->mediaService->deleteGambar($request->id_gambar)
            ? toast('Gambar Dihapus', 'success')
            : toast('Gagal', 'error');

        return redirect()->back();
    }

    public function dashPetugasAudio()
    {
        $audio = $this->mediaService->getAudioAll();

        $urlpathaudio = Storage::disk('s3')->url('audio/');

        return view('petugas.content.Audio.audioPetugas', compact('audio', 'urlpathaudio'));
    }

    public function TambahAudio(Request $request)
    {
        $this->mediaService->storeAudio($request)
            ? toast('Audio Berhasil Diupload', 'success')
            : toast('Gagal Upload Audio', 'error');

        return redirect()->back();
    }

    public function DeleteAudio(Request $request)
    {
        $this->mediaService->deleteAudio($request->id_audio)
            ? toast('Audio Dihapus', 'success')
            : toast('Gagal', 'error');

        return redirect()->back();
    }

    // ── SOAL LISTENING ──

    public function dashPetugasSoalDetailListening(Request $request, $id)
    {
        $data = $this->soalService->getDashListening((int) $id, $request->search);
        $id_bank = $id;

        $urlpathimage = Storage::disk('s3')->url('gambar/');
        $urlpathaudio = Storage::disk('s3')->url('audio/');

        return view('petugas.content.soalListening.dashSoalListening', array_merge($data, compact('id_bank', 'urlpathimage', 'urlpathaudio')));
    }

    public function TambahSoalListeningPetugas(Request $request)
    {
        $this->soalService->storeListening($request)
            ? toast('Create Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateSoalListeningPetugas(Request $request)
    {
        $this->soalService->updateListening($request)
            ? toast('Update Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteSoalListeningPetugas(Request $request)
    {
        $this->soalService->deleteSoal((int) $request->id_soal)
            ? toast('Delete Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    // ── SOAL READING ──

    public function dashPetugasSoalDetailReading(Request $request, $id)
    {
        $data = $this->soalService->getDashReading((int) $id, $request->search);
        $id_bank = $id;

        $urlpathimage = Storage::disk('s3')->url('gambar/');

        return view('petugas.content.soalReading.dashSoalReading', array_merge($data, compact('id_bank', 'urlpathimage')));
    }

    public function TambahSoalReadingPetugas(Request $request)
    {
        $this->soalService->storeReading($request)
            ? toast('Create Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateSoalReadingPetugas(Request $request)
    {
        $this->soalService->updateReading($request)
            ? toast('Update Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteSoalReadingPetugas(Request $request)
    {
        $this->soalService->deleteSoal((int) $request->id_soal)
            ? toast('Delete Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    // ── PART LISTENING ──

    public function dashPetugasPartListening(Request $request, $id)
    {
        $data = $this->partService->getDashListening((int) $id, $request->search);
        $id_bank = $id;

        $urlpathimage = Storage::disk('s3')->url('gambar/');
        $urlpathaudio = Storage::disk('s3')->url('audio/');

        return view('petugas.content.Part.partListening', array_merge($data, compact('id_bank', 'urlpathimage', 'urlpathaudio')));
    }

    public function TambahListeningPartPetugas(Request $request)
    {
        $result = $this->partService->storeListening($request);
        $result === true
            ? toast('Create Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateListeningPartPetugas(Request $request)
    {
        $result = $this->partService->updateListening($request);
        $result === true
            ? toast('Update Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteListeningPartPetugas(Request $request)
    {
        $this->partService->deletePart((int) $request->id_part)
            ? toast('Delete Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    // ── PART READING ──

    public function dashPetugasPartReading(Request $request, $id)
    {
        $data = $this->partService->getDashReading((int) $id, $request->search);
        $id_bank = $id;

        $urlpathimage = Storage::disk('s3')->url('gambar/');

        return view('petugas.content.Part.partReading', array_merge($data, compact('id_bank', 'urlpathimage')));
    }

    public function TambahReadingPartPetugas(Request $request)
    {
        $result = $this->partService->storeReading($request);
        $result === true
            ? toast('Create Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateReadingPartPetugas(Request $request)
    {
        $result = $this->partService->updateReading($request);
        $result === true
            ? toast('Update Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteReadingPartPetugas(Request $request)
    {
        $this->partService->deletePart((int) $request->id_part)
            ? toast('Delete Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function Template()
    {
        return $this->templateExcelService->downloadTemplate();
    }

    public function ResetPasswordPeserta($id)
    {
        $this->pesertaService->resetPasswordPeserta($id)
            ? toast('Password Peserta Berhasil Direset', 'success')
            : toast('Gagal Reset Password Peserta', 'error');

        return redirect()->back();
    }
}
