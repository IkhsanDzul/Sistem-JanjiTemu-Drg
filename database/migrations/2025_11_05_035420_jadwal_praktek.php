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
        Schema::create('jadwal_praktek', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('dokter_id');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])->notnull();
            $table->time('jam_mulai')->notnull();
            $table->time('jam_selesai')->notnull();
            $table->string('status', 50)->notnull();
            $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_praktek');
    }
};
