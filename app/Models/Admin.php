<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Admin extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // Tabel admin tidak memiliki timestamps

    protected $fillable = [
        'id',
        'user_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke Logs
    public function logs()
    {
        return $this->hasMany(Log::class, 'admin_id', 'user_id');
    }
}

