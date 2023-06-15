<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory;
    protected $table = 'anak';

    protected $fillable = [
        'posko_id',
        'ibu_id',
        'nama',
        'nik',
        'telp',
        'tanggal_lahir',
        'jenis_kelamin',
        'bb',
        'tb',
    ];

    public function posko()
    {
        return $this->belongsTo(Posko::class, 'posko_id');
    }

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }
}
