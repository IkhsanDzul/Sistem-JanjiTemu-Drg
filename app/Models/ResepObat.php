<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ResepObat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'resep_obats'; // Nama tabel yang benar
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'tanggal_resep',
        'nama_obat',
        'jumlah',
        'dosis',
        'aturan_pakai',
    ];

    protected $casts = [
        'tanggal_resep' => 'date',
        'jumlah' => 'integer',
        'dosis' => 'integer',
    ];

    // Relasi ke User (dokter yang membuat resep)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

