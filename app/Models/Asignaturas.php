<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignaturas extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'abreviacion'
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'asignatura_id', 'id' );
    }
}
