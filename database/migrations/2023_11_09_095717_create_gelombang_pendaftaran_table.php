<?php

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
        Schema::create('gelombang_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_pelajaran_id')->nullable()->constrained('tahun_pelajaran')->cascadeOnDelete();
            $table->string('nama');
            $table->date('mulai');
            $table->date('sampai');
            $table->boolean('aktif')->default(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelombang_pendaftaran');
    }
};
