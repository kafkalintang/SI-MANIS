<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('penilaian', function (Blueprint $table) {
        $table->id('id_penilaian');
        $table->unsignedBigInteger('mitigasi_id');
        $table->string('triwulan_tahun'); // misalnya 1-2025
        $table->enum('penilaian', ['terlampaui', 'tercapai', 'tidaktercapai']);
        $table->text('uraian')->nullable();
        $table->timestamps();

        $table->foreign('mitigasi_id')->references('id_mitigasi')->on('mitigasi')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
