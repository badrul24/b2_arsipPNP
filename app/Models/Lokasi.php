<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lokasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_lokasi', 
        'nama_lokasi',
        'keterangan'
    ];
}
