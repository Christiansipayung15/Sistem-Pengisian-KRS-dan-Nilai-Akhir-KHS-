<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model {
    // Di dalam model Dosen.php
public function mataKuliah() {
    return $this->hasMany(Matakuliah::class, 'dosen_id', 'id');
}
    protected $table = 'dosen';
    protected $primaryKey = 'nip';
    public $incrementing = false; // Karena NIP biasanya string
    protected $fillable = ['nip', 'nama', 'id_user'];
}
