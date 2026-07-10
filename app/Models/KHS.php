<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    protected $table = 'khs';

    // Tambahkan 'nilai_angka' di sini agar bisa disimpan
    protected $fillable = ['mahasiswa_id', 'krs_id', 'semester', 'nilai_angka', 'total_sks','ips', 'ipk'];

    // Relasi ke KRS
public function krs() {
    return $this->belongsTo(Krs::class, 'krs_id');
}

// Relasi ke Mahasiswa
    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
    // 3. RELASI TIDAK LANGSUNG: KHS -> KRS -> Matakuliah
    // Anda bisa memanggil $khs->krs->matakuliah di View
    public function matakuliah()
    {
        // Menggunakan relasi 'krs' yang sudah dibuat di atas
        return $this->krs()->with('matakuliah');
    }
}
