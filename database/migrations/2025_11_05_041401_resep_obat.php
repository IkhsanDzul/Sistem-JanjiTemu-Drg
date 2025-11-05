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
        Schema::create('resep_obats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->date('tanggal_resep');
            $table->string('nama_obat')->notnull();
            $table->integer('jumlah')->notnull();
            $table->integer('dosis')->notnull();
            $table->text('aturan_pakai')->notnull();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obats');
    }
};
