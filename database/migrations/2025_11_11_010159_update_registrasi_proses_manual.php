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
            // Ubah kolom proses_aktivitas_id menjadi nullable
            $table->unsignedBigInteger('proses_aktivitas_id')->nullable()->change();

            // Tambah kolom untuk input manual
            $table->string('proses_manual', 255)->nullable()->after('proses_aktivitas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            // Kembalikan kolom proses_aktivitas_id jadi not nullable
            $table->unsignedBigInteger('proses_aktivitas_id')->nullable(false)->change();

            // Hapus kolom proses_manual
            $table->dropColumn('proses_manual');
        });
    }
};
