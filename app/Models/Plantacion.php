<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantacion extends Model
{
    use HasFactory;

    protected $table = 'plantacion';
    protected $fillable = [
        'usuario',
        'fecha',
        'estado',
        'tipo'
    ];
}
