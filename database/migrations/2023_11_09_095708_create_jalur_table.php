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
        Schema::create('jalur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajaran')->cascadeOnDelete();
            $table->string('nama');
            $table->softDeletes();
        });

        Schema::create('kuota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_id')->constrained('jalur')->cascadeOnDelete();
            $table->foreignId('kompetensi_keahlian_id')->constrained('kompetensi_keahlian')->cascadeOnDelete();
            $table->unsignedInteger('kuota')->default(0);

            $table->unique(['jalur_id', 'kompetensi_keahlian_id'], 'unique_kompetensi_keahlian_index');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalur');
        Schema::dropIfExists('kuota');
    }
};
