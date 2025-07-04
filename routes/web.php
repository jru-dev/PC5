<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('oracle.auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('libros', LibroController::class);
});

// Mantener tu ruta de prueba
Route::get('/test-oracle', function () {
    try {
        $pdo = DB::connection('oracle')->getPdo();
        $result = DB::connection('oracle')->select('SELECT 1 as test FROM dual');
        return "¡Conexión exitosa! Resultado: " . json_encode($result);
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});