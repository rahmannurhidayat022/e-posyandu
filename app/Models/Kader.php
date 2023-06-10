<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kader extends Model
{
    use HasFactory;

    protected $table = 'kader';

    protected $fillable = [
        'user_id',
        'posko_id',
        'nama',
        'nik',
        'telp',
        'jabatan',
        'jalan',
        'rt',
        'rw',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posko()
    {
        return $this->belongsTo(Posko::class);
    }
}
