<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posko extends Model
{
    use HasFactory;
    protected $table = 'posko';

    protected $fillable = [
        'nama',
        'jalan',
        'rw',
    ];

    public function kaders()
    {
        return $this->hasMany(Kader::class, 'posko_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'posko_id');
    }
}
