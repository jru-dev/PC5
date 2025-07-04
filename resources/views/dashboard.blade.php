<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Biblioteca Virtual</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Bienvenido, {{ Session::get('username') }} ({{ Session::get('rol') }})
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

        <div class="row">
            <div class="col-12">
                <h2>Panel de Control</h2>
                <p>¡Bienvenido al sistema de biblioteca virtual!</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Gestión de Libros</h5>
                    </div>
                    <div class="card-body">
                        <p>Administra el catálogo de libros de la biblioteca.</p>
                        <div class="d-grid gap-2 d-md-block">
                            <a href="{{ route('libros.index') }}" class="btn btn-primary">
                                Ver Libros
                            </a>
                            @if(Session::get('rol') === 'bibliotecario')
                                <a href="{{ route('libros.create') }}" class="btn btn-success">
                                    Agregar Libro
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Estadísticas</h5>
                    </div>
                    <div class="card-body">
                        @php
                            try {
                                $stats = DB::connection('oracle')->select("
                                    SELECT 
                                        COUNT(*) as total,
                                        SUM(CASE WHEN disponible = 1 THEN 1 ELSE 0 END) as disponibles,
                                        SUM(CASE WHEN disponible = 0 THEN 1 ELSE 0 END) as prestados
                                    FROM libros
                                ");
                                $total = $stats[0]->total ?? 0;
                                $disponibles = $stats[0]->disponibles ?? 0;
                                $prestados = $stats[0]->prestados ?? 0;
                            } catch (\Exception $e) {
                                $total = 0;
                                $disponibles = 0;
                                $prestados = 0;
                            }
                        @endphp
                        
                        <p>Libros disponibles: <strong class="text-success">{{ $disponibles }}</strong></p>
                        <p>Libros prestados: <strong class="text-warning">{{ $prestados }}</strong></p>
                        <p>Total de libros: <strong class="text-primary">{{ $total }}</strong></p>
                        
                        @if($total > 0)
                            <div class="mt-3">
                                <small class="text-muted">
                                    Disponibilidad: {{ round(($disponibles/$total)*100, 1) }}%
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>