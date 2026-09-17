<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitigasi extends Model
{
    use HasFactory;

    protected $table = 'mitigasi';
    protected $primaryKey = 'id_mitigasi';

    protected $fillable = [
        'registrasi_id',
        'isurisiko',
        'rencana_aksi',
        'tanggal_pelaksanaan'
    ];

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id_registrasi');
    }

    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class, 'mitigasi_id', 'id_mitigasi');
    }

}
