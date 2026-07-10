<?php
use Illuminate\Support\Facades\Route;

// Pastikan baris ini ada dan tidak typo (perhatikan backslash \)
use App\Http\Controllers\ATMController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KrsKhsController;
Route::get('/', function () {
    return view('welcome');
});

// Baris ini yang mendaftarkan URL /atm
Route::get('/atm', [ATMController::class, 'demo']);
// Pastikan formatnya seperti ini
Route::get('/login', [LoginController::class, 'index']);
// Rute untuk Export PDF
    Route::get('/krs/export', [App\Http\Controllers\dashboard_mahasiswaController::class, 'exportKrsPdf'])
         ->name('krs.export');
         Route::post('/krs/simpan', [App\Http\Controllers\dashboard_mahasiswaController::class, 'simpanKrs'])
         ->name('krs.simpan');
Route::get('/pengolahan_krs_dan_khs', [KrsKhsController::class, 'index']);

