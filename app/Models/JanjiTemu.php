<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JanjiTemu extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'janji_temu';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'pasien_id',
        'dokter_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'keluhan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
    ];

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }

    // Relasi ke Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }

    // Relasi ke RekamMedis
    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'janji_temu_id', 'id');
    }
}

