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
        Schema::create('follow_up_marketings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_id');
            $table->foreign('marketing_id')->references('id')->on('marketings')->onDelete('cascade');
            $table->enum('status', ['1', '2', '3'])->default('1');
            $table->text('keterangan')->nullable();
            $table->string('followup')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_up_marketings');
    }
};
