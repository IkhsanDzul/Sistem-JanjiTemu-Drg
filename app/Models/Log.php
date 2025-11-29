<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Log extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'logs';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'admin_id',
        'action',
    ];

    // Relasi ke Admin
    // admin_id reference ke admin.id (sesuai dengan migration)
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    
    // Accessor untuk mendapatkan user dari admin
    public function getAdminUserAttribute()
    {
        return $this->admin ? $this->admin->user : null;
    }
}

