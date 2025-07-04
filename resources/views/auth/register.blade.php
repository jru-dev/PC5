<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Registro - Sistema de Biblioteca Virtual</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario *</label>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username') }}" 
                                       required 
                                       maxlength="50">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico *</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       maxlength="100">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña *</label>
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required 
                                               minlength="8">
                                        <div class="form-text">Mínimo 8 caracteres</div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required 
                                               minlength="8">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="rol" class="form-label">Tipo de Usuario *</label>
                                <select class="form-select @error('rol') is-invalid @enderror" 
                                        id="rol" 
                                        name="rol" 
                                        required>
                                    <option value="">Seleccionar tipo de usuario</option>
                                    <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                                    <option value="bibliotecario" {{ old('rol') == 'bibliotecario' ? 'selected' : '' }}>Bibliotecario</option>
                                </select>
                                <div class="form-text">
                                    <strong>Usuario:</strong> Puede consultar libros<br>
                                    <strong>Bibliotecario:</strong> Puede gestionar el catálogo de libros
                                </div>
                                @error('rol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Registrarse
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <p>¿Ya tienes una cuenta? 
                                    <a href="{{ route('login') }}" class="text-decoration-none">
                                        Iniciar Sesión
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>