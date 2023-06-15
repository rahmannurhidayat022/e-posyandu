<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ibu extends Model
{
    use HasFactory;
    protected $table = 'ibu';

    protected $fillable = [
        'posko_id',
        'nama',
        'nik',
        'telp',
        'tanggal_lahir',
        'jalan',
        'rt',
        'rw',
        'ayah',
        'darah',
    ];

    public function posko()
    {
        return $this->belongsTo(Posko::class, 'posko_id');
    }
}
