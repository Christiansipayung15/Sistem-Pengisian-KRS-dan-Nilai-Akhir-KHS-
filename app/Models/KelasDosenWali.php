<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasDosenWali extends Model
{
    protected $table = 'kelas_dosen_wali';
    protected $fillable = ['user_id', 'kelas_nama'];
}