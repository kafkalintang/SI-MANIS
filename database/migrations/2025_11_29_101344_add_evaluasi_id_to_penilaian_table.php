<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {

            // Tambahkan kolom evaluasi_id hanya kalau belum ada
            if (!Schema::hasColumn('penilaian', 'evaluasi_id')) {
                $table->unsignedBigInteger('evaluasi_id')->after('id_penilaian');

                $table->foreign('evaluasi_id')
                    ->references('id_evaluasi')
                    ->on('evaluasi')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropForeign(['evaluasi_id']); // hapus dulu foreign key
            $table->dropColumn('evaluasi_id');    // hapus kolom
        });
    }
};
