<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitigasi', function (Blueprint $table) {
            $table->id('id_mitigasi'); // Primary Key
            $table->unsignedBigInteger('registrasi_id'); // FK ke registrasi
            $table->string('triwulan');
            $table->string('tahun');
            $table->string('isurisiko')->nullable();
            $table->text('rencana_aksi');
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->text('hasil_tindak_lanjut')->nullable();
            $table->date('tanggal_evaluasi')->nullable();
            $table->string('status')->default('opened'); // opened / closed
            $table->text('hasil_manajemen_risiko')->nullable();
            $table->string('dokumen_pendukung')->nullable(); // URL dokumen
            $table->timestamps();

            // Foreign Key ke registrasi
            $table->foreign('registrasi_id')
                  ->references('id_registrasi')
                  ->on('registrasi')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitigasi');
    }
};
