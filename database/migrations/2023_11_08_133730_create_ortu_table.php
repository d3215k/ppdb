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
            $table->foreignId('calon_peserta_didik_id')->nullable()->constrained('calon_peserta_didik')->nullOnDelete();
            $table->string('nama');
            $table->char('nik', 16)->nullable();
            $table->char('tahun_lahir', 4)->nullable();
            $table->foreignIdFor(Pendidikan::class)->nullable();
            $table->foreignIdFor(Pekerjaan::class)->nullable();
            $table->foreignIdFor(Penghasilan::class)->nullable();
            $table->foreignIdFor(BerkebutuhanKhusus::class)->nullable();
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
