<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sifat_dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sifat')->unique();
            $table->string('nama_sifat');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sifat_dokumens');
    }
}; 