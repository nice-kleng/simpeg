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
        Schema::create('timeline_tiktoks', function (Blueprint $table) {
            $table->id();
            $table->string('kd_timeline_tiktok')->unique();
            $table->date('tanggal')->nullable();
            $table->string('tipe_konten')->nullable();
            $table->string('jenis_konten')->nullable();
            $table->string('produk')->nullable();
            $table->text('hook_konten')->nullable();
            $table->text('copywriting')->nullable();
            $table->string('jam_upload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_tiktoks');
    }
};
