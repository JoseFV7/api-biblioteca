<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        $user = User::create([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'codigo' => $request->input('codigo'),
            'dni' => $request->input('dni'),
            'rol' => $request->input('rol'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('dni', 'password'))) {
            return response()
                ->json(["message" => "Credenciales invalidas"], 401);
        }

        $user = User::where('dni', $request['dni'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                "message" => "Usuario validado",
                "token" => $token,
                "token_type" => "Bearer",
                "user" => $user,
            ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => "Te has deslogeado"
        ];
    }

    public function yo(Request $request)
{
    try {
        $user = $request->user();
        
        if ($user) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['error' => 'No hay usuario autenticado'], 401);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
