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
            $table->id(); // Kolom ID otomatis sebagai Primary Key

            // Kolom untuk informasi dokumen
            $table->string('nomor_surat')->nullable(); // Jika ini juga mencakup surat
            $table->string('judul');
            $table->date('tanggal_dokumen'); // Tanggal dokumen dibuat/diterima
            $table->text('keterangan')->nullable(); // Bisa kosong
            $table->string('file_path')->nullable(); // Path lokasi file dokumen di storage
            $table->string('nama_file_asli')->nullable(); // Nama file asli saat diupload

            // Foreign Keys untuk relasi dengan tabel master Anda
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->foreignId('kode_id')->constrained('kodes')->onDelete('restrict');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('restrict');
            $table->foreignId('retensi_id')->constrained('retensis')->onDelete('restrict');
            $table->foreignId('status_id')->constrained('status_dokumens')->onDelete('restrict');
            $table->foreignId('sifat_id')->constrained('sifat_dokumens')->onDelete('restrict');
            $table->foreignId('jenis_id')->constrained('jenis_dokumens')->onDelete('restrict');

            // Kolom untuk Jurusan dan User (penting untuk manajemen per jurusan)
            // Pastikan tabel 'jurusan' dan 'users' sudah ada sebelum menjalankan migrasi ini!
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // Siapa yang mengupload/membuat dokumen

            $table->timestamps(); // Kolom created_at dan updated_at
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

