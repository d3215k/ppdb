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
        Schema::create('gelombang', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 5);
            $table->foreignId('tahun_pelajaran_id')->nullable()->constrained('tahun_pelajaran')->cascadeOnDelete();
            $table->string('nama');
            $table->date('mulai');
            $table->date('sampai');
            $table->string('link_wa_group')->nullable();
            $table->boolean('aktif')->default(false);
            $table->softDeletes();
        });

        Schema::create('gelombang_jalur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gelombang_id')->constrained('gelombang')->cascadeOnDelete();
            $table->foreignId('jalur_id')->constrained('jalur')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelombang');
        Schema::dropIfExists('gelombang_jalur');
    }
};
