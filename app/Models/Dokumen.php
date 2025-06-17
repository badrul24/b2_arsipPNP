<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    use HasFactory;
    
    protected $table = 'dokumens';

    protected $fillable = [
        'nomor_surat',
        'judul',
        'tanggal_dokumen',
        'keterangan',
        'file_path',
        'nama_file_asli',
        'kategori_id',
        'kode_id',
        'lokasi_id',
        'retensi_id',
        'status_id',
        'sifat_id',
        'jenis_id',
        'jurusan_id',
        'user_id'
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi dengan Kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi dengan Kode Klasifikasi
    public function kode(): BelongsTo
    {
        return $this->belongsTo(Kode::class);
    }

    // Relasi dengan Lokasi Penyimpanan
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }

    // Relasi dengan Retensi Arsip
    public function retensi(): BelongsTo
    {
        return $this->belongsTo(Retensi::class);
    }

    // Relasi dengan Status Dokumen
    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusDokumen::class);
    }

    // Relasi dengan Sifat Dokumen
    public function sifat(): BelongsTo
    {
        return $this->belongsTo(SifatDokumen::class);
    }

    // Relasi dengan Jenis Dokumen
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisDokumen::class);
    }

    // Relasi dengan Jurusan
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi dengan User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
