<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'titulo',
        'autor',
        'year',
        'mueble',
        'observacion',
    ];

    public function asignatura_libro()
    {
        return $this->hasOne(Asignatura::class, 'id', 'asignatura_id');
    }
}
