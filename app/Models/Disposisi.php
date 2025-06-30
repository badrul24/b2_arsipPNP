<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisis';

    protected $fillable = [
        'surat_masuk_id',
        'user_pemberi_id',
        'user_penerima_id',
        'divisi_penerima_id',
        'jurusan_penerima_id',
        'instruksi_kepada',
        'petunjuk_disposisi',
        'isi_disposisi',
        'catatan',
        'tanggal_disposisi',
        'status_disposisi',
        'parent_disposisi_id',
    ];

    protected $casts = [
        'tanggal_disposisi' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'instruksi_kepada' => 'array',   // Ditambahkan: Cast ke array
        'petunjuk_disposisi' => 'array', // Ditambahkan: Cast ke array
    ];

    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function userPemberi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_pemberi_id');
    }

    public function userPenerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_penerima_id');
    }

    public function divisiPenerima(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_penerima_id');
    }

    public function parentDisposisi(): BelongsTo
    {
        return $this->belongsTo(Disposisi::class, 'parent_disposisi_id');
    }

    public function getInstruksiKepadaArray(): array
    {
        return $this->instruksi_kepada ?? [];
    }

    public function getPetunjukDisposisiArray(): array
    {
        return $this->petunjuk_disposisi ?? [];
    }
}
