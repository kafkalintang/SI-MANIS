<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('auditor_unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('unit_id');
            $table->timestamps();

            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('unit_kerja')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('auditor_unit');
    }
};
