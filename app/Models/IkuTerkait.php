<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IkuTerkait extends Model
{
    use HasFactory;

    protected $table = 'iku_terkait';
    
    protected $fillable = ['nama_iku'];
}
