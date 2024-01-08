<?php

use App\Enums\StatusRegistrasi;
use App\Models\GelombangPendaftaran;
use App\Models\JalurPendaftaran;
use App\Models\TahunPelajaran;
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
        Schema::create('registrasi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor');
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajaran')->cascadeOnDelete();
            $table->foreignId('jalur_pendaftaran_id')->constrained('jalur_pendaftaran')->cascadeOnDelete();
            $table->foreignId('gelombang_pendaftaran_id')->constrained('gelombang_pendaftaran')->cascadeOnDelete();
            $table->foreignId('pilihan_kesatu')->nullable()->constrained('kompetensi_keahlian')->nullOnDelete();
            $table->foreignId('pilihan_kedua')->nullable()->constrained('kompetensi_keahlian')->nullOnDelete();
            $table->unsignedTinyInteger('status')->default(StatusRegistrasi::PENDAFTARAN); // TODO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi');
    }
};
