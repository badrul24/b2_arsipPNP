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
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat_keluar')->unique();
            $table->date('tanggal_surat');
            $table->string('tujuan_surat');
            $table->string('perihal');
            $table->string('pengirim');
            $table->string('penerima');
            $table->text('isi_surat')->nullable();
            $table->text('keterangan')->nullable();

            $table->string('file_surat_path')->nullable();
            $table->string('nama_file_surat_asli')->nullable();

            $table->foreignId('jurusan_id')
                ->nullable()
                ->constrained('jurusans')
                ->onDelete('set null');

            $table->foreignId('divisi_id')
                ->nullable()
                ->constrained('divisis')
                ->onDelete('set null');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('restrict');

            $table->enum('status_surat', [
                'Draft',
                'Baru',
                'Terkirim',
                'Diterima',
                'Dibaca',
                'Selesai',
                'Diarsipkan',
            ])->default('Draft');

            $table->enum('sifat_surat', ['Sangat Penting', 'Penting', 'Biasa'])->default('Biasa');
            
            $table->enum('jenis_surat', [
                'Surat Undangan',
                'Surat Pemberitahuan',
                'Surat Permohonan',
                'Surat Keputusan',
                'Surat Edaran',
                'Surat Tugas',
                'Surat Pengantar',
                'Surat Keterangan',
                'Surat Lainnya'
            ])->default('Surat Lainnya');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
