<?php

use App\Models\BerkebutuhanKhusus;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
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
        Schema::create('ortu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_peserta_didik_id')->constrained('calon_peserta_didik')->cascadeOnDelete();

            $table->string('nama_ayah')->nullable();
            $table->char('nik_ayah', 16)->nullable();
            $table->char('tahun_lahir_ayah', 4)->nullable();
            $table->foreignId('pendidikan_ayah')->nullable()->constrained('ref_pendidikan')->nullOnDelete();
            $table->foreignId('pekerjaan_ayah')->nullable()->constrained('ref_pekerjaan')->nullOnDelete();
            $table->foreignId('penghasilan_ayah')->nullable()->constrained('ref_penghasilan')->nullOnDelete();
            $table->foreignId('berkebutuhan_khusus_ayah')->nullable()->constrained('ref_berkebutuhan_khusus')->nullOnDelete();

            $table->string('nama_ibu')->nullable();
            $table->char('nik_ibu', 16)->nullable();
            $table->char('tahun_lahir_ibu', 4)->nullable();
            $table->foreignId('pendidikan_ibu')->nullable()->constrained('ref_pendidikan')->nullOnDelete();
            $table->foreignId('pekerjaan_ibu')->nullable()->constrained('ref_pekerjaan')->nullOnDelete();
            $table->foreignId('penghasilan_ibu')->nullable()->constrained('ref_penghasilan')->nullOnDelete();
            $table->foreignId('berkebutuhan_khusus_ibu')->nullable()->constrained('ref_berkebutuhan_khusus')->nullOnDelete();

            $table->string('nama_wali')->nullable();
            $table->char('nik_wali', 16)->nullable();
            $table->char('tahun_lahir_wali', 4)->nullable();
            $table->foreignId('pendidikan_wali')->nullable()->constrained('ref_pendidikan')->nullOnDelete();
            $table->foreignId('pekerjaan_wali')->nullable()->constrained('ref_pekerjaan')->nullOnDelete();
            $table->foreignId('penghasilan_wali')->nullable()->constrained('ref_penghasilan')->nullOnDelete();
            $table->foreignId('berkebutuhan_khusus_wali')->nullable()->constrained('ref_berkebutuhan_khusus')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ortu');
    }
};
