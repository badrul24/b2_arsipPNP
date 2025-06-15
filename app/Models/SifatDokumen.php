<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SifatDokumen extends Model
{
    use HasFactory;

    protected $table = 'sifat_dokumens';

    protected $fillable = [
        'kode_sifat',
        'nama_sifat',
        'keterangan'
    ];

    // Relationships
    // public function suratMasuk()
    // {
    //     return $this->hasMany(SuratMasuk::class);
    // }

    // public function suratKeluar()
    // {
    //     return $this->hasMany(SuratKeluar::class);
    // }
} 