<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RekamMedis extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'janji_temu_id',
        'diagnosa',
        'tindakan',
        'catatan',
        'biaya',
    ];

    protected $casts = [
        'biaya' => 'decimal:2',
    ];

    // Relasi ke JanjiTemu
    public function janjiTemu()
    {
        return $this->belongsTo(JanjiTemu::class, 'janji_temu_id', 'id');
    }

    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'rekam_medis_id');
    }
}

