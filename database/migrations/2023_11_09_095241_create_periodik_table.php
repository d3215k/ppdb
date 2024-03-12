<?php

use App\Models\CalonPesertaDidik;
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
        Schema::create('periodik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_peserta_didik_id')->constrained('calon_peserta_didik')->cascadeOnDelete();
            $table->unsignedSmallInteger('tinggi')->nullable();
            $table->unsignedSmallInteger('berat')->nullable();
            $table->unsignedSmallInteger('lingkar_kepala')->nullable();
            $table->boolean('jarak_rumah')->nullable();
            $table->unsignedSmallInteger('jarak_km')->nullable();
            $table->unsignedSmallInteger('waktu_tempuh')->nullable();
            $table->unsignedSmallInteger('jumlah_saudara_kandung')->nullable();
            $table->unsignedSmallInteger('no_sepatu')->nullable();
            $table->string('ukuran_baju')->nullable();
            $table->boolean('tindik')->nullable();
            $table->boolean('tato')->nullable();
            $table->boolean('cat_rambut')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodik');
    }
};
