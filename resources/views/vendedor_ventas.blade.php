<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ventas - Vendedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style_dash.css') }}" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .logo { width: 32px; height: 32px; }
        .welcome-box {
            background: linear-gradient(135deg, #198754, #0dcaf0);
            color: white;
            padding: 30px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
<header class="navbar navbar-dark bg-dark px-4 shadow">
    <a class="navbar-brand" href="#">Dashboard Vendedor</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
    </form>
</header>

<main class="d-flex flex-nowrap">
    <!-- BARRA LATERAL -->
    <div class="sidebar p-3 bg-dark text-white">
        <div class="text-center mb-4">
            <h3>Bienvenido, {{ auth()->user()->name }}!</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('cliente.vendedor.dashboard') }}" class="nav-link text-white">
                    <i class="fas fa-box"></i> Mis Productos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendedor.productos.create') }}" class="nav-link text-white">
                    <i class="fas fa-plus-circle"></i> Agregar Producto
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendedor.ventas') }}" class="nav-link text-white active">
                    <i class="fas fa-shopping-bag"></i> Mis Ventas
                </a>
            </li>
        </ul>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container-fluid p-4">
        <div class="welcome-box mb-4">
            <h2>Mis Ventas</h2>
            <p>Aquí puedes ver todas las ventas que incluyen productos tuyos.</p>
        </div>

        @if ($ventas->isEmpty())
            <div class="alert alert-info">Aún no hay ventas con tus productos.</div>
        @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Comprador</th>
                        <th>Productos tuyos</th>
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
                                <ul class="list-unstyled mb-0">
                                    @foreach ($venta->productos as $producto)
                                        @if ($producto->vendedor_id === auth()->id())
                                            <li>{{ $producto->nombre }} (x{{ $producto->pivot->cantidad }})</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                            <td>${{ number_format($venta->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $venta->estado === 'pendiente' ? 'warning' : 'success' }}">
                                    {{ ucfirst($venta->estado) }}
                                </span>
                            </td>
                            <td>
                                @can('view', $venta)
                                    @if ($venta->ticket)
                                        <a href="{{ route('ventas.descargar', $venta) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-download"></i> Descargar
                                        </a>
                                    @else
                                        <span class="text-muted">No disponible</span>
                                    @endif
                                @else
                                    <span class="text-muted">No autorizado</span>
                                @endcan
                            </td>
                            <td>
                                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
