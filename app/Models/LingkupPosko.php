<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LingkupPosko extends Model
{
    use HasFactory;
    protected $table = 'lingkup_posko';

    protected $fillable = [
        'posko_id',
        'rt',
    ];

    public function posko()
    {
        return $this->belongsTo(Posko::class);
    }
}
