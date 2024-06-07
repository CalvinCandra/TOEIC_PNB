<?php

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PetugasController;

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

// Route::get('/test', function () {
//     return view('vendor.mail.SendMail_Template');
// });

// landing page
Route::get('/', [LandingController::class, 'index']);

// login
Route::get('/login', [AuthController::class, 'index'])->name('login');

// proses Login
Route::post('/ProsesLogin', [AuthController::class, 'ProsesLogin']);

// logout
Route::get('/logout', [AuthController::class, 'Logout']);

// kirim email petugas persatu
Route::get('/SendMail/Petugas/{id}', [MailController::class, 'SendPetugas'])->middleware('auth');
// kirim email petugas sekaligus
Route::get('/SendMailPetugasAll', [MailController::class, 'SendPetugasAll'])->middleware('auth');
// kirim email peserta persatu
Route::get('/SendMail/Peserta/{id}', [MailController::class, 'SendPeserta'])->middleware('auth');
// kirim email peserta sekaligus
Route::get('/SendMailPesertaAll', [MailController::class, 'SendPesertaAll'])->middleware('auth');

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
    Route::post('/TambahPeserta', [AdminController::class, 'TambahPeserta']);
    Route::post('/UpdatePeserta', [AdminController::class, 'UpdatePeserta']);
    Route::post('/DeletePeserta', [AdminController::class, 'DeletePeserta']);
});

//  ======================================== Grup Petugas =========================================
// ==================================== Yang Berbau Petugas, Dikerjakan di dalam Grup ini ==================================
Route::middleware(['auth', 'level:petugas'])->group(function () {
    // tampilan dashboard
    Route::get('/petugas', [PetugasController::class, 'index']);

        // dashboard Peserta
        Route::get('/dashPetugasPeserta', [PetugasController::class, 'dashPetugasPeserta']);
        Route::post('/TambahPetugasPeserta', [PetugasController::class, 'TambahPetugasPeserta']);
        Route::post('/UpdatePetugasPeserta', [PetugasController::class, 'UpdatePetugasPeserta']);
        Route::post('/DeletePetugasPeserta', [PetugasController::class, 'DeletePetugasPeserta']);
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

    // soal
    Route::get('/dashSoal', [PesertaController::class, 'dashSoal']);
    Route::get('/soal', [PesertaController::class, 'Soal']);

});


