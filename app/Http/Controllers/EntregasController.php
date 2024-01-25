<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entregas;
class EntregasController extends Controller
{
    public function api_entregas(){
        $entregas = Entregas::all();
        return response()->json($entregas);
    }
}
