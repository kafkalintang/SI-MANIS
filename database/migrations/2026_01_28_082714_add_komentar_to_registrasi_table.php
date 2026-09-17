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
        Schema::table('registrasi', function (Blueprint $table) {
            $table->text('komentar')->nullable()->after('status_registrasi');
        });
    }

    public function down()
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropColumn('komentar');
        });
    }
};
