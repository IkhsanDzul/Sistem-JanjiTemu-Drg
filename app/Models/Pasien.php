<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pasien extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pasien';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // Tabel pasien tidak memiliki timestamps

    protected $fillable = [
        'id',
        'user_id',
        'alergi',
        'golongan_darah',
        'riwayat_penyakit',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke JanjiTemu
    public function janjiTemu()
    {
        return $this->hasMany(JanjiTemu::class, 'pasien_id', 'id');
    }
    public function rekamMedis()
    {
        return $this->hasManyThrough(
            \App\Models\RekamMedis::class,   
            \App\Models\JanjiTemu::class,   
            'pasien_id',                     
            'janji_temu_id',                 
            'id',                            
            'id'                             
        );
    }
    
}

