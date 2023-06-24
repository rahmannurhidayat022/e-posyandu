<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    use HasFactory;
    protected $table = 'lansia';

    protected $fillable = [
        'posko_id',
        'nama',
        'nik',
        'darah',
        'tanggal_lahir',
        'jalan',
        'rt',
        'rw',
    ];

    public function posko()
    {
        return $this->belongsTo(Posko::class, 'posko_id');
    }
}
