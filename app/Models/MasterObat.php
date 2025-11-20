<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterObat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'master_obat';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama_obat',
        'satuan',
        'dosis_default',
        'aturan_pakai_default',
        'deskripsi',
        'aktif',
    ];

    protected $casts = [
        'dosis_default' => 'integer',
        'aktif' => 'boolean',
    ];

    /**
     * Relasi ke ResepObat (untuk melihat penggunaan)
     */
    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'nama_obat', 'nama_obat');
    }
}

