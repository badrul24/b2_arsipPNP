<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'Diverifikasi' to the ENUM list.
        // Using DB::statement because Laravel's Schema builder doesn't support modifying ENUMs directly.
        DB::statement("ALTER TABLE surat_masuks MODIFY COLUMN status_surat ENUM('Diajukan', 'Diverifikasi', 'Diproses', 'Ditolak', 'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan') NOT NULL DEFAULT 'Diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the ENUM list back to its original state, removing 'Diverifikasi'.
        DB::statement("ALTER TABLE surat_masuks MODIFY COLUMN status_surat ENUM('Diajukan', 'Diproses', 'Ditolak', 'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan') NOT NULL DEFAULT 'Diajukan'");
    }
};
