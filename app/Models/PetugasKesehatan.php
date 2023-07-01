<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasKesehatan extends Model
{
    use HasFactory;
    protected $table = 'petugas_kesehatan';

    protected $fillable = [
        'nama',
        'telp',
        'nik',
        'puskesmas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
