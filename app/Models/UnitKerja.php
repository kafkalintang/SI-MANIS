<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;

    protected $table = 'unit_kerja';

    protected $fillable = [
        'nama_unit'
    ];

    public function auditorList()
    {
        return $this->belongsToMany(User::class, 'auditor_unit', 'unit_id', 'auditor_id');
    }

    public function prosesAktivitas()
    {
        return $this->hasMany(ProsesAktivitas::class, 'unit_kerja_id');
    }

}
