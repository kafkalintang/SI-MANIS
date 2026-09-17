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
        Schema::table('registrasi', function (Blueprint $table) {

            // Hapus kolom proses_manual jika ada
            if (Schema::hasColumn('registrasi', 'proses_manual')) {
                $table->dropColumn('proses_manual');
            }

            // Kembalikan proses_aktivitas_id menjadi NOT NULL
            $table->unsignedBigInteger('proses_aktivitas_id')
                  ->nullable(false)
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {

            // Kembalikan kolom proses_manual
            $table->string('proses_manual', 255)->nullable();

            // Jika di-rollback, jadikan nullable lagi
            $table->unsignedBigInteger('proses_aktivitas_id')
                  ->nullable()
                  ->change();
        });
    }
};
