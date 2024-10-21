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
        Schema::create('report_tik_tok_lives', function (Blueprint $table) {
            $table->id();
            $table->string('kd_report_tiktok_live')->unique();
            $table->date('tanggal');
            $table->string('judul');
            $table->string('waktu_mulai');
            $table->string('durasi');
            $table->string('total_tayangan');
            $table->string('penonton_unik')->nullable();
            $table->string('rata_menonton')->nullable();
            $table->string('jumlah_penonton_teratas')->nullable();
            $table->string('pengikut')->nullable();
            $table->string('penonton_lainnya')->nullable();
            $table->string('pengikut_baru')->nullable();
            $table->string('penonton_berkomentar')->nullable();
            $table->string('suka')->nullable();
            $table->string('berbagi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_tik_tok_lives');
    }
};
