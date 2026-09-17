<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;

    protected $table = 'evaluasi';
    protected $primaryKey = 'id_evaluasi';

    protected $fillable = [
        'mitigasi_id',
        'triwulan',
        'tahun',
        'hasil_tindak_lanjut',
        'tanggal_evaluasi',
        'status_pelaksanaan',
        'hasil_penerapan',
        'dokumen_pendukung',
    ];

    public function mitigasi()
    {
        return $this->belongsTo(Mitigasi::class, 'mitigasi_id', 'id_mitigasi');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'evaluasi_id', 'id_evaluasi');
    }
}
