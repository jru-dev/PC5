<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual - Detalles del Libro</title>
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
            <h2>Detalles del Libro</h2>
            <a href="{{ route('libros.index') }}" class="btn btn-secondary">Volver a Libros</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $libro->titulo }}</h5>
                        @if($libro->disponible == 1)
                            <span class="badge bg-success fs-6">Disponible</span>
                        @else
                            <span class="badge bg-warning fs-6">Prestado</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>ID:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $libro->id }}
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Título:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $libro->titulo }}
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Autor:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $libro->autor }}
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Codigo de barras:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $libro->isbn ?? 'No especificado' }}
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Categoría:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $libro->categoria ?? 'Sin categoría' }}
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Estado:</strong>
                            </div>
                            <div class="col-md-9">
                                @if($libro->disponible == 1)
                                    <span class="text-success">✓ Disponible para préstamo</span>
                                @else
                                    <span class="text-warning">Actualmente prestado</span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Fecha registro:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $libro->created_at ?? 'No disponible' }}
                            </div>
                        </div>
                    </div>
                    
                    @if(Session::get('rol') === 'bibliotecario')
                        <div class="card-footer">
                            <div class="btn-group">
                                <a href="{{ route('libros.edit', $libro->id) }}" class="btn btn-warning">
                                    Editar Libro
                                </a>
                                <form method="POST" action="{{ route('libros.destroy', $libro->id) }}" 
                                      class="d-inline" 
                                      onsubmit="return confirm('¿Estás seguro de eliminar este libro? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Eliminar Libro
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>