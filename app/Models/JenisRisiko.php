<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisRisiko extends Model
{
    use HasFactory;

    protected $table = 'jenis_risiko';
    
    protected $fillable = ['nama_jenis'];
}
