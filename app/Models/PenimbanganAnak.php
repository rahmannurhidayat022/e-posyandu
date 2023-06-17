<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenimbanganAnak extends Model
{
    use HasFactory;
    protected $table = 'penimbangan';

    protected $fillable = [
        'posko_id',
        'petugas_id',
        'anak_id',
        'id_layanan',
        'usia',
        'bb',
        'tb',
        'bb_status',
        'suplemen',
        'keluhan',
        'catatan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_layanan = 'PA' . sprintf('%03d', static::getNextId());
        });
    }

    private static function getNextId()
    {
        $lastRecord = static::orderBy('id', 'desc')->first();

        if ($lastRecord) {
            $lastId = (int) substr($lastRecord->id_layanan, 2);
            return $lastId + 1;
        }

        return 1;
    }

    public function posko()
    {
        return $this->belongsTo(Posko::class, 'posko_id');
    }

    public function petugas()
    {
        return $this->belongsTo(PetugasKesehatan::class, 'petugas_id');
    }

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'anak_id');
    }
}
