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
        Schema::create('jawaban_mitras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_kunjungan_id')->constrained('jadwal_kunjungans');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaans');
            $table->string('jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_mitras');
    }
};
