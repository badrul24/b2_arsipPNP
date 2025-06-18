<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gauth_id',
        'gauth_type',
        'role',
        'jurusan_id',
        'divisi_id',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    public function isKepalaLembaga(): bool
    {
        return $this->role === 'kepala_lembaga';
    }

    public function isKepalaBidang(): bool
    {
        return $this->role === 'kepala_bidang';
    }

    public function isSekretaris(): bool
    {
        return $this->role === 'sekretaris';
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function getJurusanId()
    {
        return $this->jurusan_id;
    }

    public function getDivisiId()
    {
        return $this->divisi_id;
    }
}
