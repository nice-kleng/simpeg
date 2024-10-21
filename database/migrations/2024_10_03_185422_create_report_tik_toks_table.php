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
        Schema::create('report_tik_toks', function (Blueprint $table) {
            $table->id();
            $table->string('timeline_tiktok_kd', 255)->nullable();
            $table->foreign('timeline_tiktok_kd')
                ->references('kd_timeline_tiktok')
                ->on('timeline_tiktoks')
                ->onDelete('cascade');
            $table->string('views')->nullable();
            $table->string('like')->nullable();
            $table->string('comment')->nullable();
            $table->string('share')->nullable();
            $table->string('save')->nullable();
            $table->string('usia_18_24')->nullable();
            $table->string('usia_25_34')->nullable();
            $table->string('usia_35_44')->nullable();
            $table->string('usia_45_54')->nullable();
            $table->string('gender_pria')->nullable();
            $table->string('gender_wanita')->nullable();
            $table->string('total_pemutaran')->nullable();
            $table->string('rata_menonton')->nullable();
            $table->string('view_utuh')->nullable();
            $table->string('pengikut_baru')->nullable();
            $table->string('link_konten')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_tik_toks');
    }
};
