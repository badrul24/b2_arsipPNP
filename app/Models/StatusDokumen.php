<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDokumen extends Model
{
    use HasFactory;

    protected $table = 'status_dokumens';

    protected $fillable = [
        'kode_status',
        'nama_status',
        'deskripsi'
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
