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
        Schema::create('timeline_instagrams', function (Blueprint $table) {
            $table->id();
            $table->string('kd_timelineig')->unique();
            $table->date('tanggal');
            $table->string('jenis_project');
            $table->string('status');
            $table->string('format');
            $table->string('jenis_konten');
            $table->string('produk');
            $table->string('head_term')->nullable();
            $table->text('core_topic')->nullable();
            $table->text('subtopic')->nullable();
            $table->text('copywriting')->nullable();
            $table->text('notes')->nullable();
            $table->string('refrensi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_instagrams');
    }
};
