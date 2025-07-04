<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test-oracle', function () {
    try {
        // Solo probar conexión básica
        $pdo = DB::connection('oracle')->getPdo();
        
        // Probar una consulta simple
        $result = DB::connection('oracle')->select('SELECT 1 as test FROM dual');
        
        return "¡Conexión exitosa! Resultado: " . json_encode($result);
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});