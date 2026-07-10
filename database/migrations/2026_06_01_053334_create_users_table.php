<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // ID unik otomatis
        $table->string('identity_number')->unique(); // NIM/NIDN (dibuat unique agar tidak ganda)
        $table->string('name');
        $table->string('role'); // mahsiswa, dosen, atau admin
        $table->string('password'); // Kolom ini akan menyimpan hash password
        $table->rememberToken();
        $table->timestamps(); // Menambahkan kolom created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
