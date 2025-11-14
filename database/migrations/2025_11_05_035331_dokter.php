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
        Schema::create('dokter', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->string('no_str', 50)->unique();
            $table->string('pendidikan')->notnull();
            $table->string('pengalaman_tahun', 100)->notnull();
            $table->string('spesialisasi_gigi', 100)->notnull();
            $table->enum('status', ['tersedia', 'tidak tersedia'])->notnull();
            $table->foreign('user_id')->references('id')->on('users');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
