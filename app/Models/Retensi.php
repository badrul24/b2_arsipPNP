<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Retensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_retensi', 
        'nama_retensi',
        'tahun_aktif',
        'tahun_inaktif',
        'masa-retensi',
        'nasib_akhir',
        'keterangan'
    ];
}
