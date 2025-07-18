<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Retensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_retensi',
        'nama_retensi',
        'tahun_aktif',
        'tahun_inaktif',
        'nasib_akhir',
        'keterangan',
    ];

    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }
}
