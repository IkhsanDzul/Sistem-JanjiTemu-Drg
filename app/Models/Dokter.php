<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Dokter extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'dokter';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'no_str',
        'pengalaman_tahun',
        'spesialisasi_gigi',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke JadwalPraktek
    public function jadwalPraktek()
    {
        return $this->hasMany(JadwalPraktek::class, 'dokter_id', 'id');
    }

    // Relasi ke JanjiTemu
    public function janjiTemu()
    {
        return $this->hasMany(JanjiTemu::class, 'dokter_id', 'id');
    }
}

