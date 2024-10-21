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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->string('status_mitra');
            $table->string('kota_wilayah');
            $table->string('fb');
            $table->string('ig');
            $table->string('marketplace');
            $table->string('no_hp');
            $table->string('bulan');
            $table->foreignId('upline')->nullable()->constrained('mitras')->onDelete('set null');
            $table->string('note_1');
            $table->string('note_2')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
