<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void {
    $admins = [
        ['id' => 1, 'username' => 'admin_pusat', 'password' => Hash::make('admin123'), 'role' => 'admin'],
        ['id' => 3, 'username' => 'dosen_siti', 'password' => Hash::make('dosen123'), 'role' => 'dosen'],
        ['id' => 4, 'username' => 'mhs_lambok', 'password' => Hash::make('mhs123'), 'role' => 'mahasiswa'],
    ];

    foreach ($admins as $admin) {
        // updateOrInsert akan mengecek berdasarkan ID, jika ada di-update, jika belum ada di-insert
        DB::table('admin')->updateOrInsert(['id' => $admin['id']], $admin);
    }
}
        //
    }

