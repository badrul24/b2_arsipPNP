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
        Schema::create('retensis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_retensi', 10);
            $table->string('nama_retensi', 100);
            $table->integer('tahun_aktif')->default(2);
            $table->integer('tahun_inaktif')->default(3);
            $table->integer('masa_retensi')->storedAs('tahun_aktif + tahun_inaktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retensis');
    }
};
