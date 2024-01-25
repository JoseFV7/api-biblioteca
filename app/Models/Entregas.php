<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entregas extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'fecha_entrega',
        'fecha_devolucion',
        'estado',
        'reserva_id',
        'user_id',
        'demora',
    ];
}
