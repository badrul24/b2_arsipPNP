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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();

            // Kolom informasi dokumen
            $table->string('nomor_surat')->nullable();
            $table->string('judul');
            $table->date('tanggal_dokumen');
            $table->text('keterangan')->nullable();
            $table->string('file_path')->nullable();
            $table->string('nama_file_asli')->nullable();

            // Foreign Keys untuk relasi dengan tabel master
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->foreignId('kode_id')->constrained('kodes')->onDelete('restrict');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('restrict');
            $table->foreignId('retensi_id')->constrained('retensis')->onDelete('restrict');

            $table->enum('sifat', ['Sangat Penting', 'Penting', 'Biasa'])->default('Biasa');
            $table->enum('status', ['Aktif', 'Inaktif', 'Musnah'])->default('Aktif');
            $table->enum('jenis', ['Surat', 'Laporan', 'Memorandum', 'Perjanjian', 'SK'])->default('Surat');

            // Kolom untuk manajemen per jurusan dan melacak pengunggah
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
