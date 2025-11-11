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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('janji_temu_id');
            // $table->date('tanggal_periksa')->notnull();
            $table->text('diagnosa')->notnull();
            $table->text('tindakan')->notnull();
            $table->text('catatan')->nullable();
            $table->float('biaya')->notnull();
            $table->foreign('janji_temu_id')->references('id')->on('janji_temu')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
