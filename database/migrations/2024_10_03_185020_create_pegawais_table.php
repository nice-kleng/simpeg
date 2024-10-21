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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akun_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('wa')->unique();
            $table->string('ttl');
            $table->string('alamat');
            $table->string('jenkel');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('akun_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
