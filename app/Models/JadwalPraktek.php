<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JadwalPraktek extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jadwal_praktek';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'dokter_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Relasi ke Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }
}

