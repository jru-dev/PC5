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
            // Llamar al procedimiento almacenado
            $pdo = DB::connection('oracle')->getPdo();
            $stmt = $pdo->prepare("BEGIN sp_login_usuario(?, ?, ?, ?); END;");
            
            $resultado = '';
            $rol = '';
            
            $stmt->bindParam(1, $request->username);
            $stmt->bindParam(2, $request->password);
            $stmt->bindParam(3, $resultado, \PDO::PARAM_STR, 50);
            $stmt->bindParam(4, $rol, \PDO::PARAM_STR, 50);
            
            $stmt->execute();

            if ($resultado === 'SUCCESS') {
                // Guardar datos en sesión
                Session::put('user_logged', true);
                Session::put('username', $request->username);
                Session::put('rol', $rol);
                
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