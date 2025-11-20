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
        Schema::create('master_obat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_obat')->unique();
            $table->string('satuan')->default('mg'); // mg, ml, tablet, dll
            $table->integer('dosis_default')->nullable(); // Dosis default dalam satuan
            $table->text('aturan_pakai_default')->nullable(); // Aturan pakai default
            $table->text('deskripsi')->nullable(); // Deskripsi obat
            $table->boolean('aktif')->default(true); // Status aktif/tidak aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_obat');
    }
};

