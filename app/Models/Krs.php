<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model {
    protected $table = 'krs';
protected $fillable = [
    'mahasiswa_id', 
    'kode_mk', 
    'semester', 
    'status', // Tambahkan koma di sini
    'dosen_id', // Tambahkan koma di sini
    
];
public function getAngkaNilai()
    {
        $map = [
            'A' => 4,
            'B' => 3,
            'C' => 2,
            'D' => 1,
            'E' => 0
        ];
        
        // Mengambil nilai dari kolom 'nilai' di tabel krs, 
        // lalu mengonversinya sesuai array di atas
        return $map[$this->nilai] ?? 0;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
public function mahasiswa() {
    return $this->belongsTo(\App\Models\User::class, 'mahasiswa_id');
}
// Di App\Models\Krs.php
// Pastikan foreign key sesuai dengan yang ada di database
// app/Models/Krs.php
public function matakuliah() {
    return $this->belongsTo(Matakuliah::class, 'kode_mk'); // Sesuaikan dengan kolom foreign key Anda
}

    // app/Models/Krs.php
public function dosen()
{
   return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
}


    public function kelasAmpu() {
    // Relasi ke tabel kelas_ampu (asumsi id_kelas merujuk ke tabel ini)
    return $this->belongsTo(KelasAmpu::class, 'id_kelas', 'id');
}
}