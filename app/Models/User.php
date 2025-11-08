<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasUuids;

    protected $fillable = [
        'id',
        'role_id',
        'nik',
        'nama_lengkap',
        'email',
        'password',
        'foto_profil',
        'alamat',
        'jenis_kelamin',
        'tanggal_lahir',
        'nomor_telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}

