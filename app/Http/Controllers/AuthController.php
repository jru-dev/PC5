<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            // Método alternativo: usar una consulta directa primero para probar
            $user = DB::connection('oracle')->select(
                "SELECT username, rol FROM usuarios WHERE username = ? AND password = ?",
                [$request->username, $request->password]
            );

            if (!empty($user)) {
                // Guardar datos en sesión
                Session::put('user_logged', true);
                Session::put('username', $user[0]->username);
                Session::put('rol', $user[0]->rol);
                
                return redirect()->route('dashboard')->with('success', 'Bienvenido!');
            } else {
                return back()->withErrors(['login' => 'Credenciales incorrectas']);
            }
            
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Error de conexión: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }
}