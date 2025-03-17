<?php

use App\Models\Soal;
use App\Models\Nilai;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZipController;
use App\Http\Middleware\DisableHistory;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BankSoalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::post('/test', function () {
//     return "Hello";
// });

// login
Route::get('/login', [AuthController::class, 'index'])->name('login');


// proses Login
Route::post('/ProsesLogin', [AuthController::class, 'ProsesLogin']);

// logout
Route::get('/logout', [AuthController::class, 'Logout']);

// landing page
Route::get('/', [LandingController::class, 'index']);

Route::get('/dashboard', [BankSoalController::class, 'index'])->name('dashboard');
Route::post('/bank-soal/create', [BankSoalController::class, 'create'])->name('bank-soal.create');

// kirim email petugas persatu
Route::get('/SendMail/Petugas/{id}', [MailController::class, 'SendPetugas'])->middleware('auth');
// kirim email petugas sekaligus
Route::get('/SendMailPetugasAll', [MailController::class, 'SendPetugasAll'])->middleware('auth');
// kirim email peserta persatu
Route::get('/SendMail/Peserta/{id}', [MailController::class, 'SendPeserta'])->middleware('auth');
// kirim email peserta sekaligus
Route::get('/SendMailPesertaAll/{sesi}', [MailController::class, 'SendPesertaAll'])->middleware('auth');

// download zip sesuai sesi
Route::get('/downloadresult/{sesi}', [ZipController::class, 'index'])->middleware('auth');

// ========================================== Grup Admin ==========================================
// ==================================== Yang Berbau Admin, Dikerjakan di dalam Grup ini ==================================
Route::middleware(['auth', 'level:admin'])->group(function () {
    // tampilan dashboard
    Route::get('/admin', [AdminController::class, 'index']);

    // dashboard Petugas
    Route::get('/dashPetugas', [AdminController::class, 'dashPetugas']);
    Route::post('/TambahPetugas', [AdminController::class, 'TambahPetugas']);
    Route::post('/UpdatePetugas', [AdminController::class, 'UpdatePetugas']);
    Route::post('/DeletePetugas', [AdminController::class, 'DeletePetugas']);

    // dashboard Peserta
    Route::get('/dashPeserta', [AdminController::class, 'dashPeserta']);
    Route::get('/dashPeserta1', [AdminController::class, 'dashPeserta1']);
    Route::get('/dashPeserta2', [AdminController::class, 'dashPeserta2']);
    Route::get('/dashPeserta3', [AdminController::class, 'dashPeserta3']);
    Route::get('/dashPeserta4', [AdminController::class, 'dashPeserta4']);
    Route::get('/dashPeserta5', [AdminController::class, 'dashPeserta5']);
    Route::get('/dashPeserta6', [AdminController::class, 'dashPeserta6']);
    Route::get('/dashPeserta7', [AdminController::class, 'dashPeserta7']);
    Route::get('/dashPeserta8', [AdminController::class, 'dashPeserta8']);


    // Route::post('/TambahPeserta', [AdminController::class, 'TambahPeserta']);
    Route::post('/TambahPesertaExcelAdmin', [AdminController::class, 'TambahPesertaExcel']);
    Route::post('/UpdateAdminPeserta', [AdminController::class, 'UpdatePeserta']);
    Route::post('/DeleteAdminPeserta', [AdminController::class, 'DeletePeserta']);
    Route::get('/ExportExcelAdmin/{sesi}', [AdminController::class, 'ExportExcelAdmin']);
    Route::post('/ResetStatusAdmin/{sesi}', [AdminController::class, 'ResetStatusAdmin']);
    Route::post('/DeleteAllAdmin/{sesi}', [AdminController::class, 'DeleteAllAdmin']);
    Route::get('/downloadtemplate', [AdminController::class, 'Template']);

    // Gambar
    Route::get('/dashAdminGambar', [AdminController::class, 'dashAdminGambar']);
    Route::post('/TambahGambarAdmin', [AdminController::class, 'TambahGambarAdmin']);
    Route::post('/DeleteGambarAdmin', [AdminController::class, 'DeleteGambarAdmin']);

    // audio
    Route::get('/dashAdminAudio', [AdminController::class, 'dashAdminAudio']);
    Route::post('/TambahAudioAdmin', [AdminController::class, 'TambahAudioAdmin']);
    Route::post('/DeleteAudioAdmin', [AdminController::class, 'DeleteAudioAdmin']);

    // Soal
    Route::get('/dashAdminSoal', [AdminController::class, 'dashAdminSoal']);
    Route::post('/TambahBankSoalAdmin', [AdminController::class, 'TambahBankSoalAdmin']);
    Route::post('/UpdateBankSoalAdmin', [AdminController::class, 'UpdateBankSoalAdmin']);
    Route::post('/DeleteBankSoalAdmin', [AdminController::class, 'DeleteBankSoalAdmin']);

    // part soal reading
    Route::get('/dashAdminPartReading/{id}', [AdminController::class, 'dashAdminPartReading']);
    Route::post('/TambahPartReadingAdmin', [AdminController::class, 'TambahReadingPartAdmin']);
    Route::post('/UpdatePartReadingAdmin', [AdminController::class, 'UpdateReadingPartAdmin']);
    Route::post('/DeletePartReadingAdmin', [AdminController::class, 'DeleteReadingPartAdmin']);

    // part soal listening
    Route::get('/dashAdminPartListening/{id}', [AdminController::class, 'dashAdminPartListening']);
    Route::post('/TambahPartListeningAdmin', [AdminController::class, 'TambahListeningPartAdmin']);
    Route::post('/UpdatePartListeningAdmin', [AdminController::class, 'UpdateListeningPartAdmin']);
    Route::post('/DeletePartListeningAdmin', [AdminController::class, 'DeleteListeningPartAdmin']);
    

    // menampilkan detail soal reading
    Route::get('/dashAdminSoalDetailReading/{id}', [AdminController::class, 'dashAdminSoalDetailReading']);
    Route::post('/TambahSoalReadingAdmin', [AdminController::class, 'TambahSoalReadingAdmin']);
    Route::post('/UpdateSoalReadingAdmin', [AdminController::class, 'UpdateSoalReadingAdmin']);
    Route::post('/DeleteSoalReadingAdmin', [AdminController::class, 'DeleteSoalReadingAdmin']);

    // menampilkan detail soal Listening
    Route::get('/dashAdminSoalDetailListening/{id}', [AdminController::class, 'dashAdminSoalDetailListening']);
    Route::post('/TambahSoalListeningAdmin', [AdminController::class, 'TambahSoalListeningAdmin']);
    Route::post('/UpdateSoalListeningAdmin', [AdminController::class, 'UpdateSoalListeningAdmin']);
    Route::post('/DeleteSoalListeningAdmin', [AdminController::class, 'DeleteSoalListeningAdmin']);
});

//  ======================================== Grup Petugas =========================================
// ==================================== Yang Berbau Petugas, Dikerjakan di dalam Grup ini ==================================
Route::middleware(['auth', 'level:petugas'])->group(function () {
    // tampilan dashboard
    Route::get('/petugas', [PetugasController::class, 'index']);

    // Peserta
    Route::get('/dashPetugasPeserta', [PetugasController::class, 'dashPetugasPeserta']);
    Route::get('/dashPetugasPeserta1', [PetugasController::class, 'dashPetugasPeserta1']);
    Route::get('/dashPetugasPeserta2', [PetugasController::class, 'dashPetugasPeserta2']);
    Route::get('/dashPetugasPeserta3', [PetugasController::class, 'dashPetugasPeserta3']);
    Route::get('/dashPetugasPeserta4', [PetugasController::class, 'dashPetugasPeserta4']);
    Route::get('/dashPetugasPeserta5', [PetugasController::class, 'dashPetugasPeserta5']);
    Route::get('/dashPetugasPeserta6', [PetugasController::class, 'dashPetugasPeserta6']);
    Route::get('/dashPetugasPeserta7', [PetugasController::class, 'dashPetugasPeserta7']);
    Route::get('/dashPetugasPeserta8', [PetugasController::class, 'dashPetugasPeserta8']);

    // Route::post('/TambahPetugasPeserta', [PetugasController::class, 'TambahPetugasPeserta']);
    Route::post('/TambahPesertaExcelPetugas', [PetugasController::class, 'TambahPesertaExcel']);
    Route::post('/UpdatePetugasPeserta', [PetugasController::class, 'UpdatePetugasPeserta']);
    Route::post('/DeletePetugasPeserta', [PetugasController::class, 'DeletePetugasPeserta']);
    Route::get('/ExportExcelPetugas/{sesi}', [PetugasController::class, 'ExportExcelPetugas']);
    Route::post('/ResetStatusPetugas/{sesi}', [PetugasController::class, 'ResetStatusPetugas']);
    Route::post('/DeleteAllPetugas/{sesi}', [PetugasController::class, 'DeleteAllPetugas']);
    Route::get('/downloadtemplatepetugas', [PetugasController::class, 'Template']);

    // Gambar
    Route::get('/dashPetugasGambar', [PetugasController::class, 'dashPetugasGambar']);
    Route::post('/TambahGambarPetugas', [PetugasController::class, 'TambahGambarPetugas']);
    Route::post('/DeleteGambarPetugas', [PetugasController::class, 'DeleteGambarPetugas']);

    // audio
    Route::get('/dashPetugasAudio', [PetugasController::class, 'dashPetugasAudio']);
    Route::post('/TambahAudioPetugas', [PetugasController::class, 'TambahAudioPetugas']);
    Route::post('/DeleteAudioPetugas', [PetugasController::class, 'DeleteAudioPetugas']);

    // Soal
    Route::get('/dashPetugasSoal', [PetugasController::class, 'dashPetugasSoal']);
    Route::post('/TambahBankSoal', [PetugasController::class, 'TambahBankSoal']);
    Route::post('/UpdateBankSoal', [PetugasController::class, 'UpdateBankSoal']);
    Route::post('/DeleteBankSoal', [PetugasController::class, 'DeleteBankSoal']);

    // part soal reading
    Route::get('/dashPetugasPartReading/{id}', [PetugasController::class, 'dashPetugasPartReading']);
    Route::post('/TambahPartReadingPetugas', [PetugasController::class, 'TambahReadingPartPetugas']);
    Route::post('/UpdatePartReadingPetugas', [PetugasController::class, 'UpdateReadingPartPetugas']);
    Route::post('/DeletePartReadingPetugas', [PetugasController::class, 'DeleteReadingPartPetugas']);

    // part soal listening
    Route::get('/dashPetugasPartListening/{id}', [PetugasController::class, 'dashPetugasPartListening']);
    Route::post('/TambahPartListeningPetugas', [PetugasController::class, 'TambahListeningPartPetugas']);
    Route::post('/UpdatePartListeningPetugas', [PetugasController::class, 'UpdateListeningPartPetugas']);
    Route::post('/DeletePartListeningPetugas', [PetugasController::class, 'DeleteListeningPartPetugas']);

    // menampilkan detail soal reading
    Route::get('/dashPetugasSoalDetailReading/{id}', [PetugasController::class, 'dashPetugasSoalDetailReading']);
    Route::post('/TambahSoalReadingPetugas', [PetugasController::class, 'TambahSoalReadingPetugas']);
    Route::post('/UpdateSoalReadingPetugas', [PetugasController::class, 'UpdateSoalReadingPetugas']);
    Route::post('/DeleteSoalReadingPetugas', [PetugasController::class, 'DeleteSoalReadingPetugas']);

    // menampilkan detail soal Listening
    Route::get('/dashPetugasSoalDetailListening/{id}', [PetugasController::class, 'dashPetugasSoalDetailListening']);
    Route::post('/TambahSoalListeningPetugas', [PetugasController::class, 'TambahSoalListeningPetugas']);
    Route::post('/UpdateSoalListeningPetugas', [PetugasController::class, 'UpdateSoalListeningPetugas']);
    Route::post('/DeleteSoalListeningPetugas', [PetugasController::class, 'DeleteSoalListeningPetugas']);
});

// ======================================== Grup Peserta =========================================
// ==================================== Yang Berbau Peserta, Dikerjakan di dalam Grup ini ==================================
Route::middleware(['auth', 'level:peserta'])->group(function () {
    // tampilan dashboard (masih test tampilan)

    // menampilkan dashboard
    Route::get('/peserta', [PesertaController::class, 'index']);

    // profile
    Route::get('/Profil', [PesertaController::class, 'Profil']);
    Route::post('/UpdateProfil', [PesertaController::class, 'UpdateProfil']);

    // dash soal
    Route::get('/DashboardSoal', [PesertaController::class, 'dashSoal']);
    Route::get('/TokenQuestion', [PesertaController::class, 'TokenQuestion']);

    Route::middleware(['DisableHistory'])->group(function () {
        // Soal Reading
        Route::get('/Reading', [SoalController::class, 'Reading']);
        Route::get('/SoalReading', [SoalController::class, 'GetReading']);
        Route::get('/SoalReading/{token}', [SoalController::class, 'SoalReading']);
        Route::post('/ProsesJawabReading', [SoalController::class, 'ProsesJawabReading']);
        Route::get('/nilaiReading', [SoalController::class, 'GetNilaiReading'])->name('nilaiReading');

        // Listening
        Route::get('/Listening', [SoalController::class, 'Listening']);
        Route::get('/SoalListening', [SoalController::class, 'GetListening']);
        Route::get('/SoalListening/{token}', [SoalController::class, 'SoalListening']);
        Route::post('/ProsesJawabListening', [SoalController::class, 'ProsesJawabListening']);
        Route::get('/nilaiListening', [SoalController::class, 'GetNilaiListening'])->name('nilaiListening');
        Route::post('/set-audio-played', [SoalController::class, 'setPartAudioPlayed']);
        Route::post('/set-audio-played/{soalId}', [SoalController::class, 'setAudioPlayed']);
    });
   
    Route::get('/destory', [SoalController::class, 'destory']);

    // funcition result sementara
    Route::get('/Result', [NilaiController::class, 'Result']);
});
