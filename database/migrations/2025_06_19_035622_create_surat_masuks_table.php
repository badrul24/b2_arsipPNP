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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat_pengirim');
            $table->date('tanggal_surat_pengirim');
            $table->date('tanggal_terima');
            $table->string('pengirim');
            $table->string('perihal');
            $table->text('keterangan')->nullable();

            $table->string('file_surat_path')->nullable();
            $table->string('nama_file_surat_asli')->nullable();

            $table->foreignId('jurusan_id')
                ->nullable()
                ->constrained('jurusans')
                ->onDelete('set null');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('restrict');

            $table->enum('status_surat', [
                'Diajukan',
                'Diproses',
                'Ditolak',
                'Diverifikasi',
                'Disetujui',
                'Terkirim',
                'Baru',
                'Dibaca',
                'Selesai',
                'Diarsipkan',
            ])->default('Diajukan');

            $table->enum('sifat_surat', ['Sangat Penting', 'Penting', 'Biasa'])->default('Biasa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
