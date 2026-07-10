<?php

use App\Http\Controllers\ForgotPasswordController; 
use App\Http\Controllers\KrsController; // Pastikan baris use ini ada di paling atas
use App\Http\Controllers\dashboard_mahasiswaController;
use App\Http\Controllers\dashboard_dosenController;
use App\Http\Controllers\dashboard_adminController;
use App\Http\Controllers\DosenWaliController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasAmpuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MataKuliahController;
/*
|--------------------------------------------------------------------------
| Web Routes - Sistem KRS & KHS / APAO
|--------------------------------------------------------------------------
*/

// Halaman Utama: Arahkan langsung ke halaman login tunggal
// Tambahkan baris ini di routes/web.php
Route::get('/', function () {
    return redirect()->route('login');
});
// Route untuk ekspor PDF KHS
// Gunakan POST atau DELETE untuk keamanan
Route::post('/krs/acc/{id}', [KrsController::class, 'acc'])->name('krs.acc');
Route::post('/krs/tolak/{id}', [KrsController::class, 'tolak'])->name('krs.tolak');
// Di web.php

Route::get('/dosen/dashboard', [dashboard_dosenController::class, 'index'])->name('dashboard.dosen');
// Ubah dari rute lama ke rute baru
Route::get('/dosen_wali', [DosenWaliController::class, 'index'])->name('dosen.wali');
Route::post('/user/update-tipe', [dashboard_adminController::class, 'updateTipe'])->name('user.updateTipe');
Route::post('/admin/update-tipe', [App\Http\Controllers\dashboard_adminController::class, 'updateTipe'])->name('user.updateTipe');
Route::post('/dosen/hapus-nilai/{id}', [App\Http\Controllers\dashboard_dosenController::class, 'hapusNilai'])->name('dosen.hapusNilai');
Route::get('/mahasiswa/export-khs', [App\Http\Controllers\dashboard_mahasiswaController::class, 'exportPdf'])->name('mahasiswa.export.khs');
Route::post('/dosen/simpan-nilai', [dashboard_dosenController::class, 'simpanNilai'])->name('dosen.simpanNilai');
// Tambahkan baris ini agar rute dikenali
Route::put('/dosen/simpan-nilai/{id}', [App\Http\Controllers\dashboard_dosenController::class, 'updateNilaiTunggal'])->name('dosen.update.nilai');
Route::get('/dosen/input-nilai/{id}', [App\Http\Controllers\dashboard_dosenController::class, 'inputNilai'])->name('dosen.input.nilai');
Route::post('/dosen/simpan-nilai/{id}', [DashboardDosenController::class, 'simpanNilai'])->name('dosen.simpanNilai');
// Pastikan sesuaikan Controller-nya dengan yang Anda gunakan

Route::get('/mahasiswa/khs', [App\Http\Controllers\dashboard_mahasiswaController::class, 'lihatKhs'])->name('mahasiswa.khs');
Route::post('/dosen/update-status/{id}', [App\Http\Controllers\dashboard_dosenController::class, 'updateStatus'])->name('update.status.krs');
// Gunakan GET agar bisa diakses langsung via link
Route::get('/dosen/krs/reset/{id}', [App\Http\Controllers\dashboard_dosenController::class, 'hapusNilai'])->name('dosen.krs.reset');
Route::get('/mahasiswa/khs', [App\Http\Controllers\dashboard_mahasiswaController::class, 'lihatKhs'])->name('mahasiswa.khs');
Route::put('/dosen/update-nilai/{id}', [dashboard_dosenController::class, 'updateNilaiTunggal'])->name('dosen.update.nilai');
// ==========================================
// AUTENTIKASI TUNGGAL (LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Pastikan ada rute untuk dashboard mahasiswa dengan nama 'dashboard.mahasiswa'
    Route::get('/dashboard.mahasiswa', [App\Http\Controllers\dashboard_mahasiswaController::class, 'index'])
         ->name('dashboard.mahasiswa');
 Route::get('/dosen_wali', [DosenWaliController::class, 'index'])->name('dosen.wali.dashboard');
         Route::get('/dosen/matakuliah/{kode_mk}/mahasiswa', [dashboard_dosenController::class, 'detailMahasiswa'])
     ->name('dosen.matakuliah.detail');
     // Tambahkan ini di dalam group middleware(['auth']) atau di bagian routes
Route::post('/krs/simpan-semua', [App\Http\Controllers\KrsController::class, 'simpanSemua'])->name('krs.simpanSemua');
     // Tambahkan route ini untuk fitur Input Nilai Akhir
// Gunakan huruf kecil 'd' sesuai nama file Anda
    // Pastikan ada rute untuk simpan KRS dengan nama 'krs.simpan'
// Tambahkan baris ini di routes/web.php
  Route::delete('/krs/{id}', [KrsController::class, 'destroy'])->name('krs.destroy');
// Contoh penambahan route di web.php

Route::get('/krs/{id}/edit', [KrsController::class, 'edit'])->name('krs.edit');
Route::post('/krs/simpan', [dashboard_mahasiswaController::class, 'simpanKrs'])->name('krs.simpan');
// Pastikan mengarah ke method yang tepat (misal: exportKrsPdf)
Route::get('/krs/export', [App\Http\Controllers\dashboard_mahasiswaController::class, 'exportKrsPdf'])->name('krs.export');;

});
Route::put('/krs/update/{id}', [KrsController::class, 'update'])->name('krs.update');
// Halaman login utama (menampilkan form dengan dropdown role)
Route::get('/login', [loginController::class, 'showLoginForm'])->name('login');

Route::post('/krs/update-status/{id}', [dashboard_dosenController::class, 'updateStatus'])
     ->name('dosen.krs.updateStatus');
// Route untuk memproses data login (POST) -> INI YANG HARUS DIBERI NAMA 'login.submit'
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [loginController::class, 'login'])->name('login.post');

// Rute untuk menampilkan form

// Tambahkan baris ini
Route::delete('/matakuliah/{kode_mk}', [dashboard_adminController::class, 'destroyMatakuliah'])->name('matakuliah.destroy');
// Rute untuk menyimpan data (PENTING: Gunakan nama 'register.store')
// ==========================================
// DASHBOARD (SETELAH LOGIN)
// ==========================================

// Sesuaikan dengan rute Anda yang mengarah ke controller dashboard

Route::get('/dashboard_admin', [dashboard_adminController::class, 'index'])->name('dashboard_admin');
// Contoh
// Pastikan barisnya terlihat seperti ini
Route::get('/get-statistik', [DosenWaliController::class, 'getStatistikKelas'])->name('get.statistik.kelas');
Route::get('/dashboard_dosen', [App\Http\Controllers\dashboard_dosenController::class, 'dashboard']);
Route::put('/user/update-kelas', [UserController::class, 'updateKelas'])->name('user.updateKelas');
Route::resource('pengguna', dashboard_adminController::class);
Route::get('/user/{id}', [dashboard_adminController::class, 'show']);
Route::get('/user/{id}/edit', [dashboard_adminController::class, 'edit']);
Route::put('/user/{id}', [dashboard_adminController::class, 'update']);
Route::get('/admin/tambah-kelas', [KelasAmpuController::class, 'create']);
Route::post('/admin/simpan-kelas', [KelasAmpuController::class, 'store'])->name('kelas.store');

Route::post('/user/update-kelas', [dashboard_adminController::class, 'updateKelas'])->name('user.updateKelas');
Route::get('/matakuliah/{id}/edit', [dashboard_adminController::class, 'editMatakuliah'])->name('matakuliah.edit');
Route::put('/matakuliah/{id}', [dashboard_adminController::class, 'updateMatakuliah'])->name('matakuliah.update');
Route::delete('/matakuliah/{id}', [dashboard_adminController::class, 'destroyMatakuliah'])->name('matakuliah.destroy');


Route::get('/matakuliah/{kode_mk}/show', [dashboard_adminController::class, 'showMatakuliah'])->name('matakuliah.show');
Route::get('/matakuliah/{kode_mk}/edit', [dashboard_adminController::class, 'editMatakuliah'])->name('matakuliah.edit');
Route::put('/matakuliah/{kode_mk}/update', [dashboard_adminController::class, 'updateMatakuliah'])->name('matakuliah.update');

Route::post('/tambah-pengguna', [dashboard_adminController::class, 'store']);
Route::delete('/hapus-pengguna/{id}', [dashboard_adminController::class, 'destroy'])->name('user.destroy');
Route::post('/matakuliah/store', [dashboard_adminController::class, 'storeMatakuliah'])->name('matakuliah.store');
Route::get('/dashboard_mahasiswa', [dashboard_mahasiswaController::class, 'index'])->name('dashboard_mahasiswa');
// Route Lupa Password
Route::post('/matakuliah/store', [App\Http\Controllers\dashboard_adminController::class, 'storeMatakuliah'])->name('matakuliah.store');
Route::post('/matakuliah', [MataKuliahController::class, 'store'])->name('matakuliah.store');
Route::get('/lupa_password', [ForgotPasswordController::class, 'index']);
Route::post('/lupa-password/verifikasi', [ForgotPasswordController::class, 'verifikasiData'])
    ->name('verifikasi.data');

Route::post('/lupa-password/update', [ForgotPasswordController::class, 'updatePassword'])->name('update.password');
// Rute untuk proses pengiriman form (POST) yang tadi kita bahas
// Buka routes/web.php dan pastikan baris ini ada:
Route::post('/krs/simpan', [App\Http\Controllers\dashboard_mahasiswaController::class, 'simpanKrs'])->name('krs.simpan');