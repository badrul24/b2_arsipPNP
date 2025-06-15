<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HakAkses extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'role', 
        'can_view', 
        'can_create',
        'can_edit', 
        'can_delete', 
        'can_approve', 
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
