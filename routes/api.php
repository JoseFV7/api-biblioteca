<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntregasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Broadcasting\Channel;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas Register, Login y Logout
Route::get('/', [UsuariosController::class, 'usuarios']);
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('/yo',[AuthController::class, 'yo']);
});

// Rutas de Asignaturas
Route::get('/asignaturas', [AsignaturasController::class, 'api_asignaturas']);
Route::post('/asignaturas_crear', [AsignaturasController::class, 'api_asignaturas_crear']);
Route::post('/asignaturas_editar', [AsignaturasController::class, 'api_asignaturas_editar']);
Route::post('/asignaturas_eliminar', [AsignaturasController::class, 'api_asignaturas_eliminar']);

// Admin - Custom Route
Route::get('/libros_admin', [LibrosController::class, 'api_libros_admin']); //Sin paginacion
Route::get('/usuarios', [UsuariosController::class, 'usuarios']);

// Libros
Route::get('/libros', [LibrosController::class, 'api_libros']);
Route::get('/libros/{asignatura_id}', [LibrosController::class, 'api_libros_filter']);
Route::post('/libros_crear', [LibrosController::class, 'api_libros_crear']);
Route::post('/libros_editar', [LibrosController::class, 'api_libros_editar']);
Route::post('/libros_eliminar', [LibrosController::class, 'api_libros_eliminar']);
Route::post('/libros_portada', [LibrosController::class, 'api_libros_portada']);
Route::post('/libros_busqueda', [LibrosController::class, 'api_libros_busqueda']);

// Rutas de Reservas
Route::get('/reservas', [ReservasController::class,'api_reservas']);
Route::post('/reservas_crear', [ReservasController::class,'api_reservas_crear']);
Route::post('/reservas_decision', [ReservasController::class,'api_reservas_decidir']);
Route::post('/reservas_crear_ahora', [ReservasController::class,'api_reservas_ahora']);

// Rutas de Entrega
Route::get('/entregas', [EntregasController::class,'api_entregas']);
Route::get('/entregas/no_entregados', [EntregasController::class,'api_entregas_no_entregados']);
Route::get('/entregas/entregados', [EntregasController::class,'api_entregas_entregados']);
Route::post('/entregas_decision', [EntregasController::class,'api_entregas_decision']);
Route::get('/entregas/concluidos', [EntregasController::class,'api_entregas_concluidos']);
Route::post('/entregas_concluir', [EntregasController::class,'api_entregas_concluir']);

Route::get('/notifications', function () {
    return view('notifications');
});
