<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mitigasi', function (Blueprint $table) {

            if (Schema::hasColumn('mitigasi', 'hasil_tindak_lanjut')) {
                $table->dropColumn('hasil_tindak_lanjut');
            }
            if (Schema::hasColumn('mitigasi', 'tanggal_evaluasi')) {
                $table->dropColumn('tanggal_evaluasi');
            }
            if (Schema::hasColumn('mitigasi', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('mitigasi', 'hasil_manajemen_risiko')) {
                $table->dropColumn('hasil_manajemen_risiko');
            }
            if (Schema::hasColumn('mitigasi', 'dokumen_pendukung')) {
                $table->dropColumn('dokumen_pendukung');
            }

            if (Schema::hasColumn('mitigasi', 'triwulan')) {
                $table->dropColumn('triwulan');
            }
            if (Schema::hasColumn('mitigasi', 'tahun')) {
                $table->dropColumn('tahun');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
