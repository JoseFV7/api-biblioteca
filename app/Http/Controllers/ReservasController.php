<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservas;
use App\Models\Entregas;
use App\Models\Libros;
use App\Models\User;
use PhpParser\Node\Stmt\Break_;

class ReservasController extends Controller
{

    public function api_reservas()
    {
        $reservas = Reservas::all();
        foreach ($reservas as $reserva) {
            $libro = Libros::find($reserva->libro_id);
            $alumno = User::find($reserva->alumno_id);
            $demora = ReservasController::buscarDemora($alumno->id);
            $reserva->nombreLibro = $libro->titulo;
            $reserva->nombreAlumno = $alumno->nombre . ", " . $alumno->apellido;
            $reserva->demoraAlumno = $demora;
        }
        return response()->json($reservas);
    }

    public function buscarDemora($alumno_id)
    {
        $demora = 0;
        $entregas = Entregas::where('user_id', $alumno_id)->orderBy('fecha_entrega', 'DESC')->get();
        foreach ($entregas as $entrega) {
            if ($entrega->demora > 0) {
                $demora = $entrega->demora;
                break;
            }
        }
        return $demora;
    }

    public function api_reservas_crear(Request $request)
    {
        // dd();
        $reserva = new Reservas;
        $reserva->estado = 'Pendiente';
        $reserva->dias_prestamo = $request->dias_prestamo;
        $reserva->libro_id = $request->libro_id;
        $reserva->alumno_id = $request->alumno_id;
        $reserva->save();
    }

    public function api_reservas_decidir(Request $request)
    {
        $reserva = Reservas::find($request->id);
        if ($request->desicion === "true") {
            $entrega = new Entregas;
            $entrega->fecha_entrega = now()->toDateString();
            $entrega->fecha_devolucion = now()->addDays($request->dias_prestamo)->toDateString();
            $entrega->reserva_id = $request->id;
            $entrega->user_id = $request->alumno_id;
            $entrega->demora = 0;
            $entrega->estado = 'No entregado';
            $reserva->estado = 'Aceptado';
            $entrega->save();
        } else {
            $reserva->estado = 'Rechazado';
        }
        $reserva->save(); 
    }
}
