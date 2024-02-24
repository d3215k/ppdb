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
        Schema::create('rapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_peserta_didik_id')->nullable()->constrained('calon_peserta_didik')->nullOnDelete();
            $table->string('halaman_identitas')->nullable();

            $table->string('halaman_nilai_semester')->nullable();
            $table->unsignedTinyInteger('pai_1')->nullable();
            $table->unsignedTinyInteger('pai_2')->nullable();
            $table->unsignedTinyInteger('pai_3')->nullable();
            $table->unsignedTinyInteger('pai_4')->nullable();
            $table->unsignedTinyInteger('pai_5')->nullable();
            $table->unsignedTinyInteger('bindo_1')->nullable();
            $table->unsignedTinyInteger('bindo_2')->nullable();
            $table->unsignedTinyInteger('bindo_3')->nullable();
            $table->unsignedTinyInteger('bindo_4')->nullable();
            $table->unsignedTinyInteger('bindo_5')->nullable();
            $table->unsignedTinyInteger('mtk_1')->nullable();
            $table->unsignedTinyInteger('mtk_2')->nullable();
            $table->unsignedTinyInteger('mtk_3')->nullable();
            $table->unsignedTinyInteger('mtk_4')->nullable();
            $table->unsignedTinyInteger('mtk_5')->nullable();
            $table->unsignedTinyInteger('ipa_1')->nullable();
            $table->unsignedTinyInteger('ipa_2')->nullable();
            $table->unsignedTinyInteger('ipa_3')->nullable();
            $table->unsignedTinyInteger('ipa_4')->nullable();
            $table->unsignedTinyInteger('ipa_5')->nullable();
            $table->unsignedTinyInteger('ips_1')->nullable();
            $table->unsignedTinyInteger('ips_2')->nullable();
            $table->unsignedTinyInteger('ips_3')->nullable();
            $table->unsignedTinyInteger('ips_4')->nullable();
            $table->unsignedTinyInteger('ips_5')->nullable();
            $table->unsignedTinyInteger('bing_1')->nullable();
            $table->unsignedTinyInteger('bing_2')->nullable();
            $table->unsignedTinyInteger('bing_3')->nullable();
            $table->unsignedTinyInteger('bing_4')->nullable();
            $table->unsignedTinyInteger('bing_5')->nullable();

            $table->string('halaman_kehadiran')->nullable();
            $table->string('sakit')->nullable();
            $table->string('izin')->nullable();
            $table->string('alpa')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor');
    }
};
