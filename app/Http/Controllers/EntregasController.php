<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entregas;
use App\Models\Libros;
use App\Models\Reservas;
use App\Models\User;
use DateTime;
use SebastianBergmann\Diff\Diff;

class EntregasController extends Controller
{
    public function api_entregas(){
        $entregas = Entregas::orderBy('id', 'ASC')->get();
        return response()->json($entregas);
    }
    
    public function api_entregas_no_entregados(){
        $entregas = Entregas::where('estado', 'No entregado')->get();
        foreach($entregas as $entrega) {
            $reserva = Reservas::find($entrega->reserva_id);
            $libro = Libros::find($reserva->libro_id);
            $alumno = User::find($entrega->user_id);
            $entrega->alumnoNombre = $alumno->nombre . ", " . $alumno->apellido;
            $entrega->alumnoDNI = $alumno->dni;
            $entrega->libroTitulo = $libro->titulo;
            $entrega->libroCodigo = $libro->codigo;
            $entrega->dias_prestamo = $reserva->dias_prestamo;
        }
        return response()->json($entregas);
    }

    public function api_entregas_entregados(){
        $entregas = Entregas::where('estado', 'Entregado')->get();
        foreach($entregas as $entrega) {
            $reserva = Reservas::find($entrega->reserva_id);
            $libro = Libros::find($reserva->libro_id);
            $alumno = User::find($entrega->user_id);
            if (new DateTime($entrega->fecha_devolucion) < now()) {
                $entrega->demora_actual = now()->diff($entrega->fecha_devolucion)->days;
            }
            $entrega->alumnoNombre = $alumno->nombre . ", " . $alumno->apellido;
            $entrega->alumnoDNI = $alumno->dni;
            $entrega->libroTitulo = $libro->titulo;
            $entrega->libroCodigo = $libro->codigo;
        }
        return response()->json($entregas);
    }
    
    public function api_entregas_decision(Request $request){
        $entrega = Entregas::find($request->id);
        $dias_prestamo = Reservas::find($entrega->reserva_id)->dias_prestamo;
        if ($request->decision === true) {
            // dd();
            $entrega->fecha_entrega = now()->toDateString();
            $entrega->fecha_devolucion = now()->addDays($dias_prestamo)->toDateString();
            $entrega->estado = 'Entregado';
        } else {
            $entrega->estado = 'Cancelado';
        }
        $entrega->save();
    }

    public function api_entregas_concluidos(){
        $entregas = Entregas::where('estado','Concluido')->get();
        foreach($entregas as $entrega) {
            $reserva = Reservas::find($entrega->reserva_id);
            $libro = Libros::find($reserva->libro_id);
            $alumno = User::find($entrega->user_id);
            $entrega->alumnoNombre = $alumno->nombre . ", " . $alumno->apellido;
            $entrega->alumnoDNI = $alumno->dni;
            $entrega->libroTitulo = $libro->titulo;
            $entrega->libroCodigo = $libro->codigo;
        }

        return response()->json($entregas);
    }

    public function api_entregas_concluir(Request $request){
        $entrega = Entregas::find($request->id);
        $entrega->demora = $request->demora_actual;
        $entrega->estado = 'Concluido';
        $entrega->save();
    }

}
