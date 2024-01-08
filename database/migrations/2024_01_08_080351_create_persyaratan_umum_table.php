<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('persyaratan_umum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('registrasi')->cascadeOnDelete();
            $table->string('status_kelulusan_sekolah_asal')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('akta')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('ktp_ortu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratan_umum');
    }
};
