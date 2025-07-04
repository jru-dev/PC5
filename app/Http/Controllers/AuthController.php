<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

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
            // Buscar usuario por username
            $user = DB::connection('oracle')->select(
                "SELECT username, password, rol FROM usuarios WHERE username = ?",
                [$request->username]
            );

            if (!empty($user) && Hash::check($request->password, $user[0]->password)) {
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

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:bibliotecario,usuario'
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres'
        ]);

        try {
            // Verificar si el username ya existe
            $usernameExists = DB::connection('oracle')->select(
                "SELECT COUNT(*) as count FROM usuarios WHERE username = ?",
                [$request->username]
            );

            if ($usernameExists[0]->count > 0) {
                return back()->withErrors(['username' => 'Este nombre de usuario ya está en uso'])->withInput();
            }

            // Verificar si el email ya existe
            $emailExists = DB::connection('oracle')->select(
                "SELECT COUNT(*) as count FROM usuarios WHERE email = ?",
                [$request->email]
            );

            if ($emailExists[0]->count > 0) {
                return back()->withErrors(['email' => 'Este email ya está registrado'])->withInput();
            }

            // Insertar nuevo usuario
            DB::connection('oracle')->insert(
                "INSERT INTO usuarios (username, email, password, rol) VALUES (?, ?, ?, ?)",
                [
                    $request->username,
                    $request->email,
                    Hash::make($request->password), // Encriptar contraseña
                    $request->rol
                ]
            );

            return redirect()->route('login')->with('success', 'Usuario registrado exitosamente. Ya puedes iniciar sesión.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar usuario: ' . $e->getMessage()])->withInput();
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }
}