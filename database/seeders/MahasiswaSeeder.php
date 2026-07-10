<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run(): void 
    {
        // Gunakan updateOrInsert agar tidak terjadi Duplicate entry
        DB::table('mahasiswa')->updateOrInsert(
            ['nim' => '3312511087'], // Kondisi unik (berdasarkan NIM)
            [
                'nama' => 'Lambok Christian Sipayung', 
                'id_user' => 4
            ]
        );
    }
}