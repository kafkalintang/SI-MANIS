<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontenBeranda extends Model
{
    protected $table = 'konten_beranda';
    protected $fillable = ['judul', 'gambar', 'file'];
}
