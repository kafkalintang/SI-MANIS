<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriRisiko extends Model
{
    use HasFactory;

    protected $table = 'kategori_risiko';
    
    protected $fillable = ['nama_kategori'];
}
