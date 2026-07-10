<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Mahasiswa; // Tambahkan ini
use App\Models\Krs;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN BARIS INI
use Illuminate\Http\Request;
class dashboard_dosenController extends Controller
{
    public function index()
    {
        // Logika untuk menghitung jumlah status
        $krsData = Krs::with('user')->get();
        $jumlahMenunggu = Krs::where('status', 'Menunggu')->count();
        $jumlahDisetujui = Krs::where('status', 'Disetujui')->count();
        $jumlahDitolak = Krs::where('status', 'Ditolak')->count();

        // Pastikan nama file view (dosen.dashboard) sesuai
        return view('dashboard_dosen', compact('jumlahMenunggu','krsData', 'jumlahDisetujui', 'jumlahDitolak'));
    }
// Di dalam DosenController.php
public function dashboard()
{
    
    // 1. Ambil data User
    $user = Auth::user(); 

    // 2. AMBIL DATA MATA KULIAH TERLEBIH DAHULU (Pindahkan ke atas)
    // Variabel $mataKuliah didefinisikan di sini agar bisa digunakan di bawah
    
    $mataKuliah = \App\Models\Matakuliah::where('dosen_id', $user->id)->get();
    $queryKrs = \App\Models\Krs::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'));
    $totalKrs = $queryKrs->count();
    $sudahDinilai = $queryKrs->where('status', 'Sudah Dinilai')->count();
   $progressNilai = ($totalKrs > 0) ? round(($sudahDinilai / $totalKrs) * 100) : 0;
    // 3. Sekarang baru lakukan perhitungan statistik
    $jumlahMatkul = $mataKuliah->count();

    // Ganti bagian ini di dalam fungsi dashboard()
$totalMahasiswa = \App\Models\Krs::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
                                 ->distinct('mahasiswa_id') // Ubah 'nim' jadi 'mahasiswa_id'
                                 ->count('mahasiswa_id');   // Ubah 'nim' jadi 'mahasiswa_id'

    // 4. Ambil data mahasiswa dari KRS
    $dataMahasiswa = \App\Models\Krs::with(['mahasiswa', 'matakuliah'])
                        ->whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
                        ->get();

    // 5. Kirim semua variabel ke view
    return view('dashboard_dosen', compact(
        'user', 
        'jumlahMatkul', 
        'totalMahasiswa', 
        'mataKuliah', 
        'progressNilai',
        'dataMahasiswa'
    ));
}
// Pastikan file ini adalah app/Http/Controllers/dashboard_dosenController.php
public function hapusNilai($id)
{
    // 1. Cari data KRS berdasarkan ID yang dikirim dari tombol
    $krs = \App\Models\Krs::findOrFail($id);

    // 2. Update nilai menjadi null (dihapus) dan status menjadi 'Belum Dinilai'
    $krs->nilai = null;
    $krs->status = 'Belum Dinilai';
    
    // 3. Simpan perubahan ke database
    $krs->save();

    // 4. Kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Nilai berhasil dihapus dan status telah direset!');
}
public function updateStatus(Request $request, $id) {
    $krs = \App\Models\Krs::findOrFail($id);
    $krs->status = $request->status; 
    $krs->save(); // BARIS INI WAJIB ADA agar data masuk ke database
    
    return redirect()->back()->with('success', 'Status berhasil diubah!');
}
// app/Http/Controllers/dashboard_dosenController.php
// Contoh di DashboardDosenController
public function inputNilaiAkhir($kode_mk) 
{
    // Mengambil data KRS yang terkait dengan mata kuliah dan memuat data mahasiswa
    $dataMahasiswa = \App\Models\Krs::where('kode_mk', $kode_mk)
                        ->where('status', 'disetujui')
                        ->with('mahasiswa') // Pastikan relasi 'mahasiswa' ada di model Krs
                        ->get();

    return view('dashboard_dosen', compact('dataMahasiswa', 'kode_mk'));
}
// Di dalam Controller Dosen
// Di DashboardDosenController
// ... (bagian atas controller Anda)

public function simpanNilai(Request $request)
{
    // 1. Cek apakah ada data nilai yang dikirim
    $inputNilai = $request->input('nilai');

    if (!$inputNilai) {
        return redirect()->back()->with('error', 'Tidak ada nilai yang dipilih.');
    }

    // 2. Loop hanya data yang dikirim saja
    if (is_array($inputNilai)) {
        foreach ($inputNilai as $krs_id => $nilai_akhir) {
            // Hanya proses jika nilai tidak kosong
            if (!empty($nilai_akhir)) {
                $krs = \App\Models\Krs::find($krs_id);
                
                if ($krs) {
                    $krs->nilai = $nilai_akhir;
                    $krs->status = 'Sudah Dinilai'; 
                    $krs->save();
                }
            }
        }
        // Pastikan ada kurung tutup untuk if (is_array) dan foreach di sini
    } 

    return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
} // <--- KURUNG INI MENUTUP FUNGSI simpanNilai

// Sekarang fungsi private berada di luar fungsi simpanNilai
public function updateNilaiTunggal(Request $request, $id) 
{
    // 1. Cari data KRS berdasarkan ID yang dikirim
    $krs = \App\Models\Krs::findOrFail($id);
    
    // 2. Update nilai dan status
    $krs->nilai = $request->input('nilai_baru');
    $krs->status = 'Sudah Dinilai';
    
    // 3. Simpan perubahan ke database
    $krs->save();
    
    // 4. Kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Nilai berhasil diupdate!');
}
private function konversiNilai($nilai) {
    $map = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];
    return $map[$nilai] ?? 0;
}

// ... (fungsi lainnya seperti detailMahasiswa tetap di bawah sini)
public function detailMahasiswa($kode_mk) 
{
    // Mengambil semua baris KRS yang sesuai dengan ID mata kuliah yang dipilih
    // Kita gunakan 'with' untuk memuat data mahasiswa secara efisien
    $dataMahasiswa = \App\Models\Krs::where('kode_mk', $kode_mk)
                        ->with('mahasiswa') 
                        ->get();

    return view('dosen.daftar_mahasiswa', compact('dataMahasiswa', 'kode_mk'));
}
}