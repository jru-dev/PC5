<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual - Agregar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Biblioteca Virtual</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    {{ Session::get('username') }} ({{ Session::get('rol') }})
                </span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Agregar Nuevo Libro</h2>
            <a href="{{ route('libros.index') }}" class="btn btn-secondary">Volver a Libros</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
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

                        <form method="POST" action="{{ route('libros.store') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título *</label>
                                <input type="text" 
                                       class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" 
                                       name="titulo" 
                                       value="{{ old('titulo') }}" 
                                       required 
                                       maxlength="200">
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="autor" class="form-label">Autor *</label>
                                <input type="text" 
                                       class="form-control @error('autor') is-invalid @enderror" 
                                       id="autor" 
                                       name="autor" 
                                       value="{{ old('autor') }}" 
                                       required 
                                       maxlength="100">
                                @error('autor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="isbn" class="form-label">Codigo de barras</label>
                                <input type="text" 
                                       class="form-control @error('isbn') is-invalid @enderror" 
                                       id="isbn" 
                                       name="isbn" 
                                       value="{{ old('isbn') }}" 
                                       maxlength="20"
                                       placeholder="Ej: 978-0307474728">
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class="form-select @error('categoria') is-invalid @enderror" 
                                        id="categoria" 
                                        name="categoria">
                                    <option value="">Seleccionar categoría</option>
                                    <option value="Literatura" {{ old('categoria') == 'Literatura' ? 'selected' : '' }}>Literatura</option>
                                    <option value="Ficción" {{ old('categoria') == 'Ficción' ? 'selected' : '' }}>Ficción</option>
                                    <option value="Ciencia" {{ old('categoria') == 'Ciencia' ? 'selected' : '' }}>Ciencia</option>
                                    <option value="Historia" {{ old('categoria') == 'Historia' ? 'selected' : '' }}>Historia</option>
                                    <option value="Biografía" {{ old('categoria') == 'Biografía' ? 'selected' : '' }}>Biografía</option>
                                    <option value="Técnico" {{ old('categoria') == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                                    <option value="Clásicos" {{ old('categoria') == 'Clásicos' ? 'selected' : '' }}>Clásicos</option>
                                    <option value="Ensayo" {{ old('categoria') == 'Ensayo' ? 'selected' : '' }}>Ensayo</option>
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('libros.index') }}" class="btn btn-secondary me-md-2">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Agregar Libro
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>