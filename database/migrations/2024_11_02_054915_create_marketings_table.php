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
        Schema::create('marketings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sumber_marketing_id')->nullable();
            $table->foreign('sumber_marketing_id')->nullable()->references('id')->on('sumber_marketings')->onDelete('cascade');
            $table->string('nama');
            $table->string('maps')->nullable();
            $table->enum('rating', ['0', '1', '2', '3', '4'])->nullable();
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('brand')->nullable();
            $table->enum('label', ['Turlap', 'Leads', 'Brand']);
            $table->date('tanggal');
            $table->unsignedBigInteger('status_join_id')->nullable();
            // $table->foreign('status_join_id')->nullable()->references('id')->on('status_joins')->onDelete('cascade');
            $table->string('status_prospek')->nullable();
            $table->unsignedBigInteger('akun_id')->nullable();
            $table->foreign('akun_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketings');
    }
};
