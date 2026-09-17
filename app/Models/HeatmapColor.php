<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeatmapColor extends Model
{
    protected $fillable = ['row', 'col', 'color_level'];
}
