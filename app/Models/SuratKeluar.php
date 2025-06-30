<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeluar extends Model
{
    protected $fillable = [
        'nomor_agenda',
        'nomor_surat_keluar',
        'tanggal_surat',
        'tujuan_surat',
        'perihal',
        'pengirim',
        'penerima',
        'isi_surat',
        'keterangan',
        'file_surat_path',
        'nama_file_surat_asli',
        'jurusan_id',
        'divisi_id',
        'user_id',
        'status_surat',
        'sifat_surat',
        'jenis_surat',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /**
     * Get the jurusan that owns the surat keluar.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Get the divisi that owns the surat keluar.
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Get the user that owns the surat keluar.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
