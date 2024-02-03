<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libros;
use App\Models\Asignaturas;
use App\Models\Reservas;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class LibrosController extends Controller
{
    public function api_general() {

        $libros = Asignaturas::with('libros')->get();
    
        // return view('homeview', ['libros' => $libros]);
        return response()->json($libros);
        
    }
    // El paginate hace un get automatico
    public function api_libros() {
        $libros = Libros::paginate(4);
        return response()->json($libros);
    }

    public function api_libros_admin() {
        $libros = Libros::orderBy('id','ASC')->get();
        foreach ($libros as $libro) {
            $asignatura = Asignaturas::find($libro->asignatura_id);
            $libro->asignatura = $asignatura->nombre;
        }
        return response()->json($libros);
    }

    public function api_libros_busqueda(Request $request) {
        $search = $request->search;
        $filtro = $request->filtro;
        $libros = Libros::where($filtro, 'like' , '%'.$search.'%')
            ->orWhere($filtro, 'like' , '%'.ucfirst($search).'%')
            ->get();
        return response()->json($libros);
    }

    public function api_libros_filter($asignatura_id) {
        $libros = Libros::where('asignatura_id', $asignatura_id)->paginate(2);
        return response()->json($libros);
    }

    public function api_libros_crear(Request $request) {
        error_log($request);
        $libros = new Libros;
        $libros->codigo = $request->codigo;
        $libros->titulo = $request->titulo;
        $libros->autor = $request->autor;
        $libros->year = $request->year;
        $libros->mueble = $request->mueble;
        $libros->observacion = $request->observacion;
        $libros->disponibilidad = $request->disponibilidad;
        $libros->asignatura_id = $request->asignatura_id;
        if ($request->hasFile('portada')) {
            $image = $request->file('portada');
            $url = Cloudinary::upload($image->getRealPath(),['folder'=> 'Portadas', 'format' => 'webp']);
            $libros->portada = $url->getSecurePath();
        } else {
            $libros->portada = null;
        }
        $libros->save();
    }

    public function api_libros_editar(Request $request) {
        error_log($request);
        $libros = Libros::find($request->id);
        $libros->codigo = $request->codigo;
        $libros->titulo = $request->titulo;
        $libros->autor = $request->autor;
        $libros->year = $request->year;
        $libros->mueble = $request->mueble;
        $libros->observacion = $request->observacion;
        $libros->disponibilidad = $request->disponibilidad;
        $libros->asignatura_id = $request->asignatura_id;
        if ($request->hasFile('portada')) {
            $image = $request->file('portada');
            $url = Cloudinary::upload($image->getRealPath(),['folder'=> 'Portadas', 'format' => 'webp']);
            $libros->portada = $url->getSecurePath();
        } 
        // else {
        //     $libros->portada = null;
        // }
        $libros->save();
        return response()->json(["message"=> "Mensaje enviado"],200);
    }

    public function api_libros_eliminar(Request $request) {
        $libro = Libros::find($request->id);
        Reservas::where("libro_id", $libro->id)->delete();
        $libro->delete();
        return response()->json(["message"=> "Libro eliminado con exito"],200);
    }

    public function api_libros_portada(Request $request) {
        // return response()->json($request);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $subir = Cloudinary::upload($image->getRealPath(),['folder'=> 'Portadas', 'format' => 'webp']);
            $url = $subir->getSecurePath();
            return response()->json(['message' => 'Imagen guardada con éxito en la ruta: ' . $url], 200);
        } else {
            return response()->json(['error' => 'No se ha recibido ninguna imagen.'], 400);
        }
    }
}
