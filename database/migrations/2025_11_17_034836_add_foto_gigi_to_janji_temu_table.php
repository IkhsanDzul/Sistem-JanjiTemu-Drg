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
        Schema::table('janji_temu', function (Blueprint $table) {
            // Tambahkan kolom foto_gigi jika belum ada
            if (!Schema::hasColumn('janji_temu', 'foto_gigi')) {
                $table->string('foto_gigi')->nullable()->after('jam_selesai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('janji_temu', function (Blueprint $table) {
            // Hapus kolom foto_gigi jika ada
            if (Schema::hasColumn('janji_temu', 'foto_gigi')) {
                $table->dropColumn('foto_gigi');
            }
        });
    }
};
