<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumens';

    protected $fillable = [
        'kode_jenis',
        'nama_jenis',
        'keterangan'
    ];

    // public function suratMasuk()
    // {
    //     return $this->hasMany(SuratMasuk::class);
    // }

    // public function suratKeluar()
    // {
    //     return $this->hasMany(SuratKeluar::class);
    // }
}
