<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Tambahkan ini
use App\Models\Krs;  // Tambahkan ini
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk akses auth()->user()

class DosenWaliController extends Controller
{
    public function acc($id)
{
    $krs = PengajuanKRS::findOrFail($id);
    $krs->status = 'Disetujui'; // Atau sesuaikan dengan nilai di database Anda
    $krs->save();

    return back()->with('success', 'KRS berhasil disetujui');
}

public function tolak($id)
{
    $krs = PengajuanKRS::findOrFail($id);
    $krs->status = 'Ditolak';
    $krs->save();

    return back()->with('success', 'KRS berhasil ditolak');
}
public function getStatistikKelas(Request $request) 
{
    $kelas = $request->kelas;

    // Gunakan query builder agar bisa difilter secara dinamis
    $query = PengajuanKRS::query(); // Sesuaikan dengan nama model Anda

    if($kelas) {
        $query->whereHas('mahasiswa', function($q) use ($kelas) {
            $q->where('kelas', $kelas);
        });
    }

    $data = [
        'menunggu' => (clone $query)->where('status', 'Menunggu')->count(),
        'disetujui' => (clone $query)->where('status', 'Disetujui')->count(),
        'ditolak' => (clone $query)->where('status', 'Ditolak')->count(),
    ];

    return response()->json($data);
}
public function showKrs(Request $request) {
    $kelas = $request->input('kelas');
    
    $query = Krs::with('mahasiswa');

    if ($kelas) {
        // Memfilter data berdasarkan relasi kelas di tabel mahasiswa
        $query->whereHas('mahasiswa', function($q) use ($kelas) {
            $q->where('kelas', $kelas);
        });
    }

    $pengajuanKRS = $query->get();
    return view('dosen_wali.persetujuan_krs', compact('pengajuanKRS'));
}
public function dataKhs() {
    // Ambil semua mahasiswa dengan role 'mahasiswa' dan muat relasi 'krs'
   $mahasiswas = \App\Models\User::where('role', 'mahasiswa')->with('krs')->get();

    // 2. Definisi nilai
    $bobotMap = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];

    // 3. Hitung IPS & IPK
    foreach ($mahasiswas as $mhs) {
        $totalSks = 0;
        $totalNilai = 0;

        foreach ($mhs->krs as $item) {
            $sks = $item->sks ?? 3; // Asumsi kolom sks ada di tabel krs
            $bobot = $bobotMap[strtoupper($item->nilai)] ?? 0;
            
            $totalSks += $sks;
            $totalNilai += ($bobot * $sks);
        }

        $mhs->ips = ($totalSks > 0) ? ($totalNilai / $totalSks) : 0;
        $mhs->ipk = $mhs->ips; 
    }
    // Kirim variabel $mahasiswas ke view
    return view('dosen_wali', compact('mahasiswas'));
}
public function index()
{
    $dosen = auth()->user(); 

    // 1. Ambil daftar kelas yang diampu dosen
    $daftarKelas = \App\Models\KelasDosenWali::where('user_id', $dosen->id)
                                             ->pluck('kelas_nama')
                                             ->toArray();

    // 2. Ambil mahasiswa KHS DAN lakukan perhitungan IPS/IPK di sini
 $mahasiswas = \App\Models\User::where('role', 'mahasiswa')
                ->whereIn('kelas', $daftarKelas)
                ->with('krs') // WAJIB ada agar data nilai terbaca
                ->get();

$bobotMap = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];

foreach ($mahasiswas as $mhs) {
    $totalSks = 0;
    $totalNilai = 0;

    // Pastikan $mhs->krs memiliki data
    if ($mhs->krs && $mhs->krs->count() > 0) {
        foreach ($mhs->krs as $item) {
            $sks = $item->sks ?? 3; 
            $bobot = $bobotMap[strtoupper($item->nilai)] ?? 0;
            
            $totalSks += $sks;
            $totalNilai += ($bobot * $sks);
        }
        $mhs->ips = $totalSks > 0 ? ($totalNilai / $totalSks) : 0;
    } else {
        $mhs->ips = 0; // Jika tidak ada KRS, IPS = 0
    }
    $mhs->ipk = $mhs->ips; 
}

    // 3. Query lain untuk KRS
    $krsQuery = \App\Models\Krs::whereHas('mahasiswa', function($query) use ($daftarKelas) {
        $query->whereIn('kelas', $daftarKelas);
    });

    $pengajuanKRS = (clone $krsQuery)->with(['mahasiswa', 'matakuliah'])->get();
    $jumlahMenunggu = (clone $krsQuery)->where('status', 'Pending')->count();
    $jumlahDisetujui = (clone $krsQuery)->where('status', 'Disetujui')->count();
    $jumlahDitolak = (clone $krsQuery)->where('status', 'Ditolak')->count();

    // 4. Kirim SEMUA variabel yang dibutuhkan oleh view
    return view('dosen_wali', compact(
        'mahasiswas', // Gunakan nama ini agar cocok dengan @foreach di blade
        'pengajuanKRS', 
        'jumlahMenunggu', 
        'jumlahDisetujui', 
        'jumlahDitolak'
    ));
}
}
