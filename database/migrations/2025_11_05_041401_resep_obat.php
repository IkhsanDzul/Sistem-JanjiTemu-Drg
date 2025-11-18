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
        Schema::create('resep_obat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('rekam_medis_id');
            $table->string('dokter_id');
            $table->date('tanggal_resep');
            $table->string('nama_obat')->notnull();
            $table->integer('jumlah')->notnull();
            $table->integer('dosis')->notnull();
            $table->text('aturan_pakai')->notnull();
            $table->timestamps();
            $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('rekam_medis_id')->references('id')->on('rekam_medis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obat');
    }
};
