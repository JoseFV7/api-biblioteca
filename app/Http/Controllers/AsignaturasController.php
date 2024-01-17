<?php

namespace App\Http\Controllers;

use App\Models\Asignaturas;
use App\Models\Libros;
use App\Models\Reservas;
use Illuminate\Http\Request;
class AsignaturasController extends Controller
{
    public function api_asignaturas(Request $request){
        $asignaturas = Asignaturas::orderBy('id', 'ASC')->get();
        $request->headers->set('ngrok-skip-browser-warning', '1234');        
        return response()->json($asignaturas);
    }

    public function api_asignaturas_crear(Request $request){
        $asignatura = new Asignaturas;
        $asignatura->nombre = $request->nombre;
        $asignatura->abreviacion = $request->abreviacion;
        $asignatura->save();
        return response()->json(['estado'=>"Asignatura creada con exito"],200);
    }

    public function api_asignaturas_editar(Request $request){
        $asignatura = Asignaturas::find($request->id);
        $asignatura->nombre = $request->nombre;
        $asignatura->abreviacion = $request->abreviacion;
        $asignatura->save();
        return response()->json(['estado'=>"Asignatura modificada con exito"],200);
    }

    public function api_asignaturas_eliminar(Request $request){
        $asignatura = Asignaturas::find($request->id);
        $libros = Libros::where("asignatura_id", $asignatura->id)->get();
        foreach($libros as $libro){
            Reservas::where("libro_id", $libro->id)->delete();
        }
        Libros::where("asignatura_id", $asignatura->id)->delete();
        $asignatura->delete();
        return response()->json(['estado'=>"Asignatura eliminada con exito"],200);
    }
}
