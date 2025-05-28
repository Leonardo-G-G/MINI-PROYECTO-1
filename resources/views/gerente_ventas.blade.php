<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Gerente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style_dash.css') }}" rel="stylesheet">
</head>
<body>
<header class="navbar navbar-dark bg-dark px-4 shadow">
    <a class="navbar-brand" href="#">Ventas - Gerente</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
    </form>
</header>

<main class="d-flex flex-nowrap">
    <!-- BARRA LATERAL -->
    <div class="sidebar">
        <div class="text-center text-white mb-4">
            <h3>Bienvenido, {{ auth()->user()->name }}!</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('gerente.dashboard') }}" class="nav-link">
                    <i class="fas fa-users"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ventas.index') }}" class="nav-link active">
                    <i class="fas fa-shopping-cart"></i> Ventas
                </a>
            </li>
        </ul>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container-fluid py-4">
        <div class="welcome-message mb-4">
            <h2>Gestor de Ventas</h2>
            <p>Listado de todas las ventas realizadas por los clientes.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Comprador</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Ticket</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ $venta->comprador->name }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach ($venta->productos as $producto)
                                        <li>
                                            {{ $producto->nombre }} (x{{ $producto->pivot->cantidad }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>${{ number_format($venta->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $venta->estado == 'pendiente' ? 'warning' : ($venta->estado == 'completada' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($venta->estado) }}
                                </span>
                            </td>
                            <td>
                                @if ($venta->ticket)
                                    <a href="{{ route('ventas.descargar', $venta) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-file-download"></i> Descargar
                                    </a>
                                @else
                                    <span class="text-muted">No disponible</span>
                                @endif
                            </td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver detalles
                                </a>
                                @if ($venta->estado === 'pendiente')
                                    <form action="{{ route('ventas.validar', $venta) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Validar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
