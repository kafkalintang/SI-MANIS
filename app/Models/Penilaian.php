<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';
    protected $fillable = [
        'evaluasi_id',
        'triwulan_tahun',
        'uraian'
    ];

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class, 'evaluasi_id', 'id_evaluasi');
    }
}
