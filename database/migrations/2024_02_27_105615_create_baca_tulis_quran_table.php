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
        Schema::create('baca_tulis_quran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_peserta_didik_id')->constrained('calon_peserta_didik')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('kelancaran')->nullable();
            $table->unsignedInteger('kefasihan')->nullable();
            $table->unsignedInteger('tajwid')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baca_tulis_quran');
    }
};
