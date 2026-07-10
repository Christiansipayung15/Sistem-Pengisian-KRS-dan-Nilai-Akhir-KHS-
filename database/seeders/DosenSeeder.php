<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <--- INI YANG KURANG
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  
 public function run(): void {
    $dataDosen = [
        ['nip' => '19850101', 'nama' => 'Dr. Budi Santoso, M.T.', 'id_user' => 2],
        ['nip' => '19900505', 'nama' => 'Siti Aminah, M.Kom.', 'id_user' => 3],
    ];

    foreach ($dataDosen as $dosen) {
        DB::table('dosen')->updateOrInsert(
            ['nip' => $dosen['nip']], // Cek berdasarkan Primary Key (NIP)
            $dosen                    // Update jika ada, Insert jika belum ada
        );
    }
}
        //
    }

