<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libros;
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
        return $this->hasMany(Libros::class, 'asignatura_id', 'id' );
    }
}
