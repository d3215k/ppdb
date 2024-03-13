<?php

use App\Enums\StatusPendaftaran;
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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_peserta_didik_id')->constrained('calon_peserta_didik')->cascadeOnDelete();
            $table->string('nomor');
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajaran')->cascadeOnDelete();
            $table->foreignId('jalur_id')->constrained('jalur')->cascadeOnDelete();
            $table->foreignId('gelombang_id')->constrained('gelombang')->cascadeOnDelete();
            $table->foreignId('pilihan_kesatu')->nullable()->constrained('kompetensi_keahlian')->nullOnDelete();
            $table->foreignId('pilihan_kedua')->nullable()->constrained('kompetensi_keahlian')->nullOnDelete();
            $table->unsignedTinyInteger('status')->default(StatusPendaftaran::PENDAFTARAN); // TODO
            $table->timestamps();

            $table->unique(['calon_peserta_didik_id', 'tahun_pelajaran_id', 'gelombang_id'], 'unique_pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
