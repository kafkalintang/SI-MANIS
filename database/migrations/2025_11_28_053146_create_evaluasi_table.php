<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluasi', function (Blueprint $table) {
            $table->id('id_evaluasi');
            $table->unsignedBigInteger('mitigasi_id');

            $table->string('triwulan')->nullable();
            $table->string('tahun')->nullable();
            $table->text('hasil_tindak_lanjut')->nullable();
            $table->date('tanggal_evaluasi')->nullable();
            $table->string('status_pelaksanaan')->default('open');
            $table->text('hasil_penerapan')->nullable();
            $table->string('dokumen_pendukung')->nullable();

            $table->timestamps();

            $table->foreign('mitigasi_id')
                ->references('id_mitigasi')->on('mitigasi')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi');
    }
};
