<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'nama_kode',
        'kategori_id',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
