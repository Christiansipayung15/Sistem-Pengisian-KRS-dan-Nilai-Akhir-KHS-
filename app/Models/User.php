<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // PENTING
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    
    use Notifiable;
    // Pastikan nama tabel di sini SAMA PERSIS dengan di phpMyAdmin
    protected $table = 'users'; 
protected $fillable = [
    'name', 
    'email', 
    'password', 
    'identity_number', 
    'role',
    'tipe_dosen'
];
// Di app/Models/User.php
public function nilai() {
    // Sesuaikan 'mahasiswa_id' dengan nama kolom di tabel nilai Anda
    return $this->hasMany(Nilai::class, 'mahasiswa_id', 'id');
}
// Tambahkan ini di dalam class User
// Tambahkan fungsi ini di dalam class User
public function krs() {
    // Sesuaikan 'mahasiswa_id' dengan nama kolom di tabel krs Anda
    return $this->hasMany(\App\Models\Krs::class, 'mahasiswa_id', 'id');
}
public function khs()
{
    // Ganti 'user_id' dengan nama kolom yang BENAR-BENAR ada di tabel khs
    // Contoh jika kolomnya bernama 'mahasiswa_id':
    return $this->hasOne(Khs::class, 'mahasiswa_id'); 
}
}
