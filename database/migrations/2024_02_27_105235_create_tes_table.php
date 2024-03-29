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
        Schema::create('tes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_peserta_didik_id')->constrained('calon_peserta_didik')->cascadeOnDelete();
            $table->unsignedInteger('minat_bakat')->nullable();
            $table->unsignedInteger('khusus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tes');
    }
};
