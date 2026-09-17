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
    Schema::create('registrasi', function (Blueprint $table) {
        $table->id('id_registrasi');
        
        // Foreign keys
        $table->unsignedBigInteger('unit_kerja_id');
        $table->unsignedBigInteger('proses_aktivitas_id');
        $table->unsignedBigInteger('kategori_risiko_id');
        $table->unsignedBigInteger('jenis_risiko_id');
        $table->unsignedBigInteger('iku_terkait_id');

        // Data risiko
        $table->string('isu_resiko', 255);
        $table->string('jenis_isu', 100);
        $table->text('akar_permasalahan');
        $table->text('dampak');
        $table->string('pihak_terkait', 255);
        $table->text('kontrol_pencegahan');

        // Parameter risiko
        $table->string('keparahan', 10);
        $table->string('frekuensi', 10);
        $table->string('probabilitas', 10);

        // Status
        $table->string('status_registrasi', 50)->default('Draft');

        $table->timestamps();

        // Relasi ke tabel master
        $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->onDelete('cascade');
        $table->foreign('proses_aktivitas_id')->references('id')->on('proses_aktivitas')->onDelete('cascade');
        $table->foreign('kategori_risiko_id')->references('id')->on('kategori_risiko')->onDelete('cascade');
        $table->foreign('jenis_risiko_id')->references('id')->on('jenis_risiko')->onDelete('cascade');
        $table->foreign('iku_terkait_id')->references('id')->on('iku_terkait')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi');
    }
};
