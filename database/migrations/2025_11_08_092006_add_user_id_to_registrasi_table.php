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
        Schema::table('registrasi', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // tambahkan nullable dulu
            // jangan pakai constrained() dulu
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
