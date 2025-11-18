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
        Schema::table('jadwal_praktek', function (Blueprint $table) {
            // Hapus kolom hari jika ada
            if (Schema::hasColumn('jadwal_praktek', 'hari')) {
                $table->dropColumn('hari');
            }
            
            // Tambahkan kolom tanggal jika belum ada
            if (!Schema::hasColumn('jadwal_praktek', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('dokter_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_praktek', function (Blueprint $table) {
            // Hapus kolom tanggal jika ada
            if (Schema::hasColumn('jadwal_praktek', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
            
            // Tambahkan kembali kolom hari
            if (!Schema::hasColumn('jadwal_praktek', 'hari')) {
                $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])->after('dokter_id');
            }
        });
    }
};
