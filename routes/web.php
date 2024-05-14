<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
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

// login
Route::get('/', [AuthController::class, 'index'])->name('login');

// proses Login
Route::post('/ProsesLogin', [AuthController::class, 'ProsesLogin']);

// logout
Route::get('/logout', [AuthController::class, 'Logout']);

// ========================================== Grup Admin ==========================================
// ==================================== Yang Berbau Admin, Dikerjakan di dalam Grup ini ==================================
Route::group(['middleware' => ['auth', 'level:admin']], function (){
    // tampilan dashboard
    Route::get('/admin', [AdminController::class, 'index']);

});

//  ======================================== Grup Petugas =========================================
Route::group(['middleware' => ['auth', 'level:petugas']], function (){
    Route::get('/petugas', [PetugasController::class, 'index']);

});

// ======================================== Grup Peserta =========================================
Route::group(['middleware' => ['auth', 'level:peserta']], function (){


});

