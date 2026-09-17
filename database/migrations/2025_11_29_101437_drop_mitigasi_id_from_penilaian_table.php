<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {

            if (Schema::hasColumn('penilaian', 'mitigasi_id')) {
                $table->dropForeign(['mitigasi_id']);
                $table->dropColumn('mitigasi_id');
            }

        });
    }


    public function down(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->unsignedBigInteger('mitigasi_id')->after('id_penilaian')->nullable();
            // opsional: tambahkan kembali foreign key
            // $table->foreign('mitigasi_id')->references('id_mitigasi')->on('mitigasi')->onDelete('cascade');
        });
    }
};
