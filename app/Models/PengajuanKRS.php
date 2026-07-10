<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanKRS extends Model
{
    // Pastikan nama tabel di database sesuai
   protected $table = 'krs'; 

 public function mahasiswa()
    {
        // Parameter: class model tujuan, foreign key (di tabel KRS), local key (di tabel Mahasiswa)
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'kode_mk', 'kode_mk');
    }
}