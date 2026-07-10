<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // INI WAJIB ADA

class KelasAmpuSeeder extends Seeder
{
    public function run(): void 
    {
        $kelas = [
            ['id' => 1, 'kode_mk' => 'IF101', 'nip_dosen' => '19850101', 'tahun_ajaran' => '2025/2026'],
            ['id' => 2, 'kode_mk' => 'IF202', 'nip_dosen' => '19900505', 'tahun_ajaran' => '2025/2026'],
        ];

        foreach ($kelas as $k) {
            DB::table('kelas_ampu')->updateOrInsert(
                ['id' => $k['id']], 
                $k
            );
        }
    }
}