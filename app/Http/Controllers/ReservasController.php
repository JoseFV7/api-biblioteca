<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservas;
use App\Models\Libros;
use App\Models\Usuarios;
class ReservasController extends Controller
{

    public function api_reservas(){
        $reservas = Reservas::all();
        foreach ($reservas as $reserva) {
            $libro = Libros::find($reserva->libro_id);
            $alumno = Usuarios::find($reserva->alumno_id); 
            $reserva->nombreLibro = $libro->titulo;
            $reserva->nombreAlumno = $alumno->nombre .", ".$alumno->apellido;
        }
        return response()->json($reservas);
    }

    public function api_reservas_crear(Request $request){
        // dd();
        $reserva = new Reservas;
        $reserva->fecha_entrega = $request->fecha_entrega;
        $reserva->fecha_devolucion = $request->fecha_devolucion;
        $reserva->libro_id = $request->libro_id;
        $reserva->alumno_id = $request->alumno_id;
        $reserva->save();
    }

    public function api_reservas_editar(Request $request){
        $reserva = Reservas::find($request->id);
        // dd($request);
        $reserva->fecha_entrega = $request->fecha_entrega;
        $reserva->fecha_devolucion = $request->fecha_devolucion;
        $reserva->libro_id = $request->libro_id;
        $reserva->alumno_id = $request->alumno_id;
        $reserva->save();
    }

    public function api_reservas_eliminar(Request $request){
        $reserva = Reservas::find($request->id);
        $reserva->delete();
    }
}
