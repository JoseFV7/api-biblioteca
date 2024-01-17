<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuarios extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'codigo',
        'dni',
        'edad',
        'password',
    ];

    protected $hidden = [
        // 'password',
    ];
}
