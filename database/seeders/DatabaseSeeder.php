<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DosenSeeder::class,
            MatakuliahSeeder::class,
            MahasiswaSeeder::class,
            KelasAmpuSeeder::class,
            // Tambahkan seeder lain jika ada
        ]);
    }
}