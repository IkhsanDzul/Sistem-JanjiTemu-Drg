<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = false; // karena id bukan auto increment (string)
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama_role',
    ];

    // Relasi ke user
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}

