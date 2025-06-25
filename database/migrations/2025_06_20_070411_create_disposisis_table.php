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
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')
                  ->constrained('surat_masuks')
                  ->onDelete('cascade');

            $table->foreignId('user_pemberi_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            $table->foreignId('user_penerima_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->foreignId('divisi_penerima_id')
                  ->nullable()
                  ->constrained('divisis')
                  ->onDelete('set null');

            $table->foreignId('jurusan_penerima_id')
                  ->nullable()
                  ->constrained('jurusans')
                  ->onDelete('set null');

            $table->text('instruksi_kepada')->nullable(); 
            $table->text('petunjuk_disposisi')->nullable(); 

            $table->text('isi_disposisi');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_disposisi');

            $table->enum('status_disposisi', [
                'Baru',
                'Diterima',
                'Dikerjakan',
                'Selesai',
                'Ditolak',
                'Diteruskan'
            ])->default('Baru');

            $table->foreignId('parent_disposisi_id')
                  ->nullable()
                  ->constrained('disposisis')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
