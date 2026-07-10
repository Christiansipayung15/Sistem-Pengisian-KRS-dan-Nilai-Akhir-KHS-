<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanKRS;
use App\Models\Krs; // TAMBAHKAN INI
use App\Models\KHS; //
class KrsController extends Controller
{
    public function update(Request $request, $id)
    {
        // Logika untuk update nilai
        // Contoh:
        // $krs = Krs::findOrFail($id);
        // $krs->update(['nilai' => $request->nilai]);
        // return redirect()->back()->with('success', 'Nilai berhasil diupdate');
    }
public function simpanSemua(Request $request)
{
    // Hapus dd() lama. Gunakan ini untuk memastikan loop berjalan:
    if (!$request->has('nilai')) {
        return "Error: Data nilai kosong.";
    }

    foreach ($request->nilai as $id_krs => $nilai_input) {
        $krs = Krs::findOrFail($id_krs);
        $krs->nilai = $nilai_input;
        $krs->save();

        // Gunakan create() sementara untuk tes paksa (bukan updateOrCreate)
        \App\Models\KHS::create([
            'mahasiswa_id' => $krs->mahasiswa_id,
            'krs_id'       => $id_krs,
            'nilai_angka'  => $nilai_input,
            'semester'     => '1'
        ]);
    }
    
    return "Data telah diproses ke database.";
}

private function hitungDanSimpanIpsIpk($mahasiswa_id)
{
    // 1. Ambil semua nilai mahasiswa di semester 1
    $dataKHS = \App\Models\KHS::where('mahasiswa_id', $mahasiswa_id)
                                ->where('semester', '1')
                                ->get();
    
    $total_bobot = 0;
    $total_sks = 0;

    foreach ($dataKHS as $item) {
        // Konversi nilai (A=4, B=3, dll)
        $map = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];
        $bobot = $map[$item->nilai_angka] ?? 0;
        
        // Ambil SKS dari tabel matakuliah (pastikan relasi tersedia)
        $sks = $item->krs->matakuliah->sks ?? 0; 
        
        $total_bobot += ($bobot * $sks);
        $total_sks += $sks;
    }

    // 2. Hitung IPS
    $ips = ($total_sks > 0) ? ($total_bobot / $total_sks) : 0;
    $ipk = $ips; // Untuk semester 1, IPK = IPS

    // 3. Simpan ke database
    \App\Models\KHS::where('mahasiswa_id', $mahasiswa_id)
        ->where('semester', '1')
        ->update([
            'ips' => $ips,
            'ipk' => $ipk
        ]);
}
public function acc($id)
    {
        $krs = PengajuanKRS::findOrFail($id);
        $krs->status = 'Disetujui'; 
        $krs->save();

        return redirect()->back()->with('success', 'KRS berhasil disetujui');
    }

    // Tambahkan method ini jika belum ada
    public function tolak($id)
    {
        $krs = PengajuanKRS::findOrFail($id);
        $krs->status = 'Ditolak';
        $krs->save();

        return redirect()->back()->with('success', 'KRS berhasil ditolak');
    }

    public function resetNilai($id)
{
    // Cari data berdasarkan ID
    $krs = Krs::findOrFail($id);
    
    // Set nilai menjadi null (kosong)
    $krs->nilai = null;
    $krs->save();
    
    return redirect()->back()->with('success', 'Nilai berhasil dihapus.');
}
}