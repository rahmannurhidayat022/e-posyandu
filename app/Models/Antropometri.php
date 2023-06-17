<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antropometri extends Model
{
    use HasFactory;
    protected $table = 'antropometri';

    protected $fillable = [
        'jenis_kelamin',
        'bulan',
        'bb_min',
        'bb_max',
        'tb_min',
        'tb_max',
    ];
}
