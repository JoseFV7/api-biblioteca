<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservas;
use App\Models\Entregas;
use App\Models\Libros;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReservasController extends Controller
{

    public function api_reservas()
    {
        $reservas = Reservas::where('estado', 'Pendiente')->get();
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
        $entregas = Entregas::where('user_id', $alumno_id)
            ->whereDate('fecha_entrega', '>', now()->subDays(30))
            ->orderBy('fecha_entrega', 'DESC')->get();
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
        if ($request->decision === true) {
            // dd();
            $entrega = new Entregas;
            $entrega->fecha_entrega = now()->toDateString();
            $entrega->fecha_devolucion = now()->addDays($reserva->dias_prestamo)->toDateString();
            $entrega->reserva_id = $reserva->id;
            $entrega->user_id = $reserva->alumno_id;
            $entrega->demora = 0;
            $entrega->estado = 'No entregado';
            $reserva->estado = 'Aceptado';
            $entrega->save();
        } else {
            $reserva->estado = 'Rechazado';
        }
        $reserva->save();
    }

    public function api_reservas_ahora(Request $request)
    {
        $reserva = new Reservas;
        $reserva->estado = 'Aceptado';
        $reserva->dias_prestamo = 1;
        $libro = Libros::where('codigo', $request->libro_codigo)->first();
        $reserva->libro_id = $libro->id;
        $alumno = User::where('dni', (int)$request->alumno_dni)->first();
        $reserva->alumno_id = $alumno->id;
        $reserva->save();
        $entrega = new Entregas;
        $entrega->fecha_entrega = now()->toDateString();
        $entrega->fecha_devolucion = now()->toDateString();
        $entrega->reserva_id = $reserva->id;
        $entrega->user_id = $reserva->alumno_id;
        $entrega->demora = 0;
        $entrega->estado = 'Entregado';
        $entrega->save();
    }
}
