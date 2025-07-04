<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual - Libros</title>
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
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Libros</h2>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Volver al Dashboard</a>
                @if(Session::get('rol') === 'bibliotecario')
                    <a href="{{ route('libros.create') }}" class="btn btn-primary">Agregar Libro</a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if(empty($libros))
                    <p class="text-center text-muted">No hay libros registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>Codigo de barras</th>
                                    <th>Categoría</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($libros as $libro)
                                    <tr>
                                        <td>{{ $libro->id }}</td>
                                        <td>{{ $libro->titulo }}</td>
                                        <td>{{ $libro->autor }}</td>
                                        <td>{{ $libro->isbn ?? 'N/A' }}</td>
                                        <td>{{ $libro->categoria ?? 'N/A' }}</td>
                                        <td>
                                            @if($libro->disponible == 1)
                                                <span class="badge bg-success">Disponible</span>
                                            @else
                                                <span class="badge bg-warning">Prestado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('libros.show', $libro->id) }}" 
                                                   class="btn btn-outline-info">Ver</a>
                                                
                                                @if(Session::get('rol') === 'bibliotecario')
                                                    <a href="{{ route('libros.edit', $libro->id) }}" 
                                                       class="btn btn-outline-warning">Editar</a>
                                                    
                                                    <form method="POST" action="{{ route('libros.destroy', $libro->id) }}" 
                                                          class="d-inline" 
                                                          onsubmit="return confirm('¿Estás seguro de eliminar este libro?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>