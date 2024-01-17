<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Http\Requests\StoreUsuariosRequest;
use App\Http\Requests\UpdateUsuariosRequest;
use App\Models\User;

class UsuariosController extends Controller
{
    public function usuarios(){
        $alumnos = User::all();
        return response()->json($alumnos);
    }
}
