<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'kode_jurusan', 
        'nama_jurusan', 
        'keterangan'];
}
