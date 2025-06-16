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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->onDelete('set null');
            // Gunakan ->nullable() jika ada user yang tidak terikat jurusan (misal: Admin Global)
            // Gunakan ->onDelete('set null') agar jika jurusan dihapus, user tidak ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });
    }
};