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
        Schema::create('calon_peserta_didik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajaran')->cascadeOnDelete();
            $table->string('nama');
            $table->char('lp', 1);
            $table->char('nisn', 10)->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->char('nik', 16)->nullable();
            $table->char('kk', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_reg_akta')->nullable();
            $table->foreignId('agama_id')->nullable()->constrained('ref_agama')->nullOnDelete();
            $table->foreignId('berkebutuhan_khusus_id')->nullable()->constrained('ref_berkebutuhan_khusus')->nullOnDelete();
            $table->string('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('lintang')->nullable();
            $table->string('bujur')->nullable();
            $table->foreignId('tempat_tinggal_id')->nullable()->constrained('ref_tempat_tinggal')->nullOnDelete();
            $table->foreignId('moda_transportasi_id')->nullable()->constrained('ref_moda_transportasi')->nullOnDelete();
            $table->unsignedSmallInteger('anak_ke')->nullable();
            $table->string('nomor_hp', 16)->nullable();
            $table->string('nomor_hp_ortu', 16)->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('asal_sekolah_id')->nullable()->constrained('asal_sekolah')->nullOnDelete();

            $table->string('username')->nullable(); // akun dinas
            $table->string('password')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_peserta_didik');
    }
};
