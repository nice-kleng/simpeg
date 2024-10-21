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
        Schema::create('report_timeline_instagrams', function (Blueprint $table) {
            $table->id();
            $table->string('timeline_instagram_kd', 255)->nullable();
            $table->foreign('timeline_instagram_kd')
                ->references('kd_timelineig')
                ->on('timeline_instagrams')
                ->onDelete('set null');
            $table->string('jangkauan')->nullable();
            $table->string('interaksi')->nullable();
            $table->string('aktivitas')->nullable();
            $table->string('impresi')->nullable();
            $table->string('like')->nullable();
            $table->string('comment')->nullable();
            $table->string('share')->nullable();
            $table->string('save')->nullable();
            $table->string('pengikut')->nullable();
            // $table->string('pengikut_baru')->nullable();
            $table->string('bukan_pengikut')->nullable();
            $table->string('profile')->nullable();
            $table->string('beranda')->nullable();
            $table->string('jelajahi')->nullable();
            $table->string('lainnya')->nullable();
            $table->string('tagar')->nullable();
            $table->string('jumlah_pemutaran')->nullable();
            $table->string('waktu_tonton')->nullable();
            $table->string('rata')->nullable();
            $table->string('link_konten')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_timeline_instagrams', function (Blueprint $table) {
            $table->dropForeign(['timeline_instagram_kd']);
        });
        Schema::dropIfExists('report_timeline_instagrams');
    }
};
