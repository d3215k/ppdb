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

            $table->unsignedInteger('pai')->default(0);
            $table->unsignedTinyInteger('pai_1')->default(0);
            $table->unsignedTinyInteger('pai_2')->default(0);
            $table->unsignedTinyInteger('pai_3')->default(0);
            $table->unsignedTinyInteger('pai_4')->default(0);
            $table->unsignedTinyInteger('pai_5')->default(0);

            $table->unsignedInteger('bindo')->default(0);
            $table->unsignedTinyInteger('bindo_1')->default(0);
            $table->unsignedTinyInteger('bindo_2')->default(0);
            $table->unsignedTinyInteger('bindo_3')->default(0);
            $table->unsignedTinyInteger('bindo_4')->default(0);
            $table->unsignedTinyInteger('bindo_5')->default(0);

            $table->unsignedInteger('mtk')->default(0);
            $table->unsignedTinyInteger('mtk_1')->default(0);
            $table->unsignedTinyInteger('mtk_2')->default(0);
            $table->unsignedTinyInteger('mtk_3')->default(0);
            $table->unsignedTinyInteger('mtk_4')->default(0);
            $table->unsignedTinyInteger('mtk_5')->default(0);

            $table->unsignedInteger('ipa')->default(0);
            $table->unsignedTinyInteger('ipa_1')->default(0);
            $table->unsignedTinyInteger('ipa_2')->default(0);
            $table->unsignedTinyInteger('ipa_3')->default(0);
            $table->unsignedTinyInteger('ipa_4')->default(0);
            $table->unsignedTinyInteger('ipa_5')->default(0);

            $table->unsignedInteger('ips')->default(0);
            $table->unsignedTinyInteger('ips_1')->default(0);
            $table->unsignedTinyInteger('ips_2')->default(0);
            $table->unsignedTinyInteger('ips_3')->default(0);
            $table->unsignedTinyInteger('ips_4')->default(0);
            $table->unsignedTinyInteger('ips_5')->default(0);

            $table->unsignedInteger('bing')->default(0);
            $table->unsignedTinyInteger('bing_1')->default(0);
            $table->unsignedTinyInteger('bing_2')->default(0);
            $table->unsignedTinyInteger('bing_3')->default(0);
            $table->unsignedTinyInteger('bing_4')->default(0);
            $table->unsignedTinyInteger('bing_5')->default(0);

            $table->unsignedInteger('sum')->default(0);
            $table->float('avg')->default(0);

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
