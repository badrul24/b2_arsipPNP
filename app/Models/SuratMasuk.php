<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuks';

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat_pengirim',
        'tanggal_surat_pengirim',
        'tanggal_terima',
        'pengirim',
        'perihal',
        'keterangan',
        'file_surat_path',
        'nama_file_surat_asli',
        'jurusan_id',
        'user_id',
        'status_surat',
        'sifat_surat',
    ];

    protected $casts = [
        'tanggal_surat_pengirim' => 'date',
        'tanggal_terima' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status_surat' => 'string',
        'sifat_surat' => 'string',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function disposisis(): HasMany
    {
        return $this->hasMany(Disposisi::class);
    }
}
