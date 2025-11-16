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
        Schema::create('janji_temu', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('pasien_id');
            $table->string('dokter_id');
            $table->date('tanggal')->notnull();
            $table->time('jam_mulai')->notnull();
            $table->time('jam_selesai')->notnull();
            $table->string('foto_gigi')->nullable();
            $table->string('keluhan')->notnull();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'canceled'])->notnull();
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('janji_temu');
    }
};
