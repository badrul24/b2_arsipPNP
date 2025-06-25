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
            $table->string('kode_retensi', 10)->unique();
            $table->string('nama_retensi', 100)->unique();
            $table->integer('tahun_aktif')->default(2);
            $table->integer('tahun_inaktif')->default(3);
            $table->enum('nasib_akhir', ['Musnah', 'Permanen', 'Dinilai Kembali'])->nullable();
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
