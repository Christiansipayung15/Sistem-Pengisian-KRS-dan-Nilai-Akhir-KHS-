<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        $matakuliah = [
            ['kode_mk' => 'IF101', 'nama_mk' => 'Pemrograman Web', 'sks' => 3, 'semester' => 2],
            ['kode_mk' => 'IF202', 'nama_mk' => 'Basis Data', 'sks' => 4, 'semester' => 2],
        ];

        foreach ($matakuliah as $mk) {
            // updateOrInsert: Jika kode_mk sudah ada, update datanya. Jika belum, masukkan.
            DB::table('matakuliah')->updateOrInsert(
                ['kode_mk' => $mk['kode_mk']], 
                $mk
            );
        }
    }
}