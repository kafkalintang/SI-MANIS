<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesAktivitas extends Model
{
    use HasFactory;

    protected $table = 'proses_aktivitas';
    
    protected $fillable = ['nama_proses', 'unit_kerja_id'];

    public function unitKerja()
{
    return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
}

}
