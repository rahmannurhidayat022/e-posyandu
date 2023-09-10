<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaksin extends Model
{
    use HasFactory;
    protected $table = 'vaksin';
    protected $fillable = ['name', 'type', 'variant', 'batch_number', 'expired_date'];
}
