<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
