<?php

namespace App\Http\Controllers;

use App\Services\Media\MediaService;
use App\Services\Part\PartService;
use App\Services\Peserta\PesertaService;
use App\Services\Soal\BankSoalService;
use App\Services\Soal\SoalCrudService;
use App\Services\Staff\PetugasAdminService;
use App\Services\TemplateExcelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct(
        protected PesertaService $pesertaService,
        protected SoalCrudService $soalService,
        protected BankSoalService $bankSoalService,
        protected PartService $partService,
        protected MediaService $mediaService,
        protected PetugasAdminService $petugasService,
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

        $chartData = [];
        foreach ($sessions as $sesi) {
            $chartData[] = [
                'sesi' => $sesi,
                'data' => [
                    'Done' => $data->where('sesi', $sesi)->where('status', 'Sudah')->sum('total') ?? 0,
                    'Work' => $data->where('sesi', $sesi)->where('status', 'Kerjain')->sum('total') ?? 0,
                    'Not Yet' => $data->where('sesi', $sesi)->where('status', 'Belum')->sum('total') ?? 0,
                ],
                'total' => $data->where('sesi', $sesi)->sum('total'),
            ];
        }

        return view('admin.content.dashboard', compact('sessions', 'statuses', 'chartData'));
    }

    public function dashPetugas()
    {
        $petugas = $this->petugasService->getPetugasAll(request('search'));

        return view('admin.content.Pegawai.AdminPegawai', compact('petugas'));
    }

    public function TambahPetugas(Request $request)
    {
        $this->petugasService->storePetugas($request)
            ? toast('Petugas Berhasil Ditambah', 'success')
            : toast('Gagal Menambah Petugas', 'error');

        return redirect()->back();
    }

    public function UpdatePetugas(Request $request)
    {
        $this->petugasService->updatePetugas($request)
            ? toast('Petugas Berhasil Diupdate', 'success')
            : toast('Gagal Update Petugas', 'error');

        return redirect()->back();
    }

    public function DeletePetugas(Request $request)
    {
        $this->petugasService->deletePetugas($request)
            ? toast('Petugas Berhasil Dihapus', 'success')
            : toast('Gagal Hapus Petugas', 'error');

        return redirect()->back();
    }

    public function dashPeserta()
    {
        $peserta = $this->pesertaService->getPesertaAll(request('search'));

        return view('admin.content.Peserta.AdminPeserta', compact('peserta'));
    }

    public function dashPeserta1()
    {
        $peserta = $this->pesertaService->getPesertaBySesi('Session 1', request('search'));

        return view('admin.content.Peserta.AdminPeserta1', compact('peserta'));
    }

    public function dashPeserta2()
    {
        $peserta = $this->pesertaService->getPesertaBySesi('Session 2', request('search'));

        return view('admin.content.Peserta.AdminPeserta2', compact('peserta'));
    }

    public function TambahPesertaExcel(Request $request)
    {
        $this->pesertaService->importPesertaExcel($request)
            ? toast('Import Berhasil', 'success')
            : toast('Import Gagal', 'error');

        return redirect()->back();
    }

    public function UpdatePeserta(Request $request)
    {
        $this->pesertaService->updatePeserta($request)
            ? toast('Peserta Berhasil Diupdate', 'success')
            : toast('Gagal Update Peserta', 'error');

        return redirect()->back();
    }

    public function DeletePeserta(Request $request)
    {
        $this->pesertaService->deletePeserta($request)
            ? toast('Peserta Berhasil Dihapus', 'success')
            : toast('Gagal Hapus Peserta', 'error');

        return redirect()->back();
    }

    public function ResetPasswordPeserta($id)
    {
        $this->pesertaService->resetPasswordPeserta($id)
            ? toast('Password Peserta Berhasil Direset', 'success')
            : toast('Gagal Reset Password Peserta', 'error');

        return redirect()->back();
    }

    public function ResetAllStatusPeserta($sesi)
    {
        $this->pesertaService->resetAllStatusPeserta($sesi);
        toast('Status Semua Peserta Direset', 'success');

        return redirect()->back();
    }

    public function ExportExcelAdmin($sesi)
    {
        return $this->pesertaService->exportExcel($sesi);
    }

    public function dashAdminSoal()
    {
        $bank = $this->bankSoalService->getBankSoalAll();

        return view('admin.content.BankSoal.dashbanksoal', compact('bank'));
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
            ? toast('Bank Soal Dihapus', 'success')
            : toast('Gagal', 'error');

        return redirect()->back();
    }

    public function dashAdminGambar()
    {
        $gambar = $this->mediaService->getGambarAll();

        return view('admin.content.Gambar.gambarAdmin', compact('gambar'));
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

    public function dashAdminAudio()
    {
        $audio = $this->mediaService->getAudioAll();

        return view('admin.content.Audio.audioAdmin', compact('audio'));
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

    public function dashAdminSoalDetailListening(Request $request, $id)
    {
        $data = $this->soalService->getDashListening((int) $id, $request->search);
        $id_bank = $id;

        return view('admin.content.SoalListening.dashSoalListening', array_merge($data, compact('id_bank')));
    }

    public function TambahSoalListeningAdmin(Request $request)
    {
        $this->soalService->storeListening($request)
            ? toast('Create Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateSoalListeningAdmin(Request $request)
    {
        $this->soalService->updateListening($request)
            ? toast('Update Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteSoalListeningAdmin(Request $request)
    {
        $this->soalService->deleteSoal((int) $request->id_soal)
            ? toast('Delete Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    // ── SOAL READING ──

    public function dashAdminSoalDetailReading(Request $request, $id)
    {
        $data = $this->soalService->getDashReading((int) $id, $request->search);
        $id_bank = $id;

        return view('admin.content.SoalReading.dashSoalReading', array_merge($data, compact('id_bank')));
    }

    public function TambahSoalReadingAdmin(Request $request)
    {
        $this->soalService->storeReading($request)
            ? toast('Create Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateSoalReadingAdmin(Request $request)
    {
        $this->soalService->updateReading($request)
            ? toast('Update Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteSoalReadingAdmin(Request $request)
    {
        $this->soalService->deleteSoal((int) $request->id_soal)
            ? toast('Delete Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    // ── PART LISTENING ──

    public function dashAdminPartListening(Request $request, $id)
    {
        $data = $this->partService->getDashListening((int) $id, $request->search);
        $id_bank = $id;

        return view('admin.content.Part.partListening', array_merge($data, compact('id_bank')));
    }

    public function TambahListeningPartAdmin(Request $request)
    {
        $result = $this->partService->storeListening($request);
        $result === true
            ? toast('Create Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateListeningPartAdmin(Request $request)
    {
        $result = $this->partService->updateListening($request);
        $result === true
            ? toast('Update Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteListeningPartAdmin(Request $request)
    {
        $this->partService->deletePart((int) $request->id_part)
            ? toast('Delete Data Successful!', 'success')
            : toast('Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    // ── PART READING ──

    public function dashAdminPartReading(Request $request, $id)
    {
        $data = $this->partService->getDashReading((int) $id, $request->search);
        $id_bank = $id;

        return view('admin.content.Part.partReading', array_merge($data, compact('id_bank')));
    }

    public function TambahReadingPartAdmin(Request $request)
    {
        $result = $this->partService->storeReading($request);
        $result === true
            ? toast('Create Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function UpdateReadingPartAdmin(Request $request)
    {
        $result = $this->partService->updateReading($request);
        $result === true
            ? toast('Update Data Successful!', 'success')
            : toast(is_string($result) ? $result : 'Terjadi kesalahan', 'error');

        return redirect()->back();
    }

    public function DeleteReadingPartAdmin(Request $request)
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
}
