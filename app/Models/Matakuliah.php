<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $table = 'mata_kuliah'; // Sesuaikan dengan nama tabel di phpMyAdmin Anda
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'semester', 'dosen_id'];
    public function dosen()
{
    // Pastikan 'dosen_id' adalah nama kolom foreign key di tabel mata_kuliah Anda
    return $this->belongsTo(\App\Models\User::class, 'dosen_id');
}
    
}