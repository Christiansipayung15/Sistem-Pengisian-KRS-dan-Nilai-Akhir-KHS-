<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasAmpu extends Model
{
    // Tambahkan baris ini agar Laravel tahu nama tabel yang benar di database
    protected $table = 'kelas_ampu';

    // Jika Anda memiliki relasi, pastikan kodenya benar
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }



public function dosen() {
    // Menghubungkan kelas_ampu ke dosen berdasarkan nip_dosen
    return $this->belongsTo(\App\Models\Dosen::class, 'nip_dosen', 'nip');
}
}