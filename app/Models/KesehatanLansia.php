<?php

namespace App\Models;

use App\Http\Services\ReformatDate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KesehatanLansia extends Model
{
    use HasFactory;
    protected $table = 'kesehatan_lansia';

    protected $fillable = [
        'posko_id',
        'petugas_id',
        'lansia_id',
        'id_layanan',
        'bb',
        'tb',
        'tekanan_darah',
        'kolestrol',
        'gula_darah',
        'keluhan',
        'catatan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_layanan = 'KL' . sprintf('%03d', static::getNextId());
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

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ReformatDate::updateDateTimeTimezone($value),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ReformatDate::updateDateTimeTimezone($value),
        );
    }

    public function posko()
    {
        return $this->belongsTo(Posko::class, 'posko_id');
    }

    public function petugas()
    {
        return $this->belongsTo(PetugasKesehatan::class, 'petugas_id');
    }

    public function lansia()
    {
        return $this->belongsTo(Lansia::class, 'lansia_id');
    }
}
