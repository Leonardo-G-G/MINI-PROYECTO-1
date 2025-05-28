<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas Administrativas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link href="{{ asset('css/style_dash.css') }}" rel="stylesheet">
    <style>
        .stat-card {
            transition: transform 0.2s ease;
        }
        .stat-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .badge-pill {
            font-size: 1rem;
            padding: 0.5em 0.9em;
        }
    </style>
</head>
<body>
<header class="navbar navbar-dark bg-dark px-4 shadow">
    <a class="navbar-brand" href="#">Dashboard admin</a>
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
                <a href="{{ route('admin.usuarios.index') }}" class="nav-link">
                    <i class="fas fa-users"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categorias.index') }}" class="nav-link">
                    <i class="fas fa-list"></i> Categorías
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.productos.index') }}" class="nav-link">
                    <i class="fas fa-boxes"></i> Productos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.estadisticas') }}" class="nav-link active">
                    <i class="fas fa-chart-bar"></i> Estadísticas
                </a>
            </li>
        </ul>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container-fluid p-5">
        <h2 class="mb-4">Estadísticas Generales del Sistema</h2>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card stat-card text-white bg-primary shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h5 class="card-title">Usuarios Registrados</h5>
                        <p class="card-text display-6">{{ $totalUsuarios }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card text-white bg-success shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-tag fa-2x mb-2"></i>
                        <h5 class="card-title">Vendedores</h5>
                        <p class="card-text display-6">{{ $totalVendedores }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card text-white bg-info shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                        <h5 class="card-title">Compradores</h5>
                        <p class="card-text display-6">{{ $totalCompradores }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3">Productos por Categoría</h4>
        <ul class="list-group list-group-flush mb-4">
            @foreach ($productosPorCategoria as $cat)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $cat->nombre }}
                    <span class="badge bg-secondary badge-pill">{{ $cat->productos_count }}</span>
                </li>
            @endforeach
        </ul>

        <h4 class="mb-3">Producto Más Vendido</h4>
        @if($productoMasVendido)
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-crown me-2"></i>
                <strong>{{ $productoMasVendido->nombre }}</strong> — Vendido <strong>{{ $productoMasVendido->total_vendidos }}</strong> veces.
            </div>
        @else
            <div class="alert alert-warning">Aún no hay productos vendidos.</div>
        @endif

        <h4 class="mb-3">Comprador Más Frecuente por Categoría</h4>
        <ul class="list-group mb-5">
            @foreach ($compradorPorCategoria as $data)
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="fas fa-tags me-2"></i> {{ $data['categoria'] }}</span>
                    <strong>{{ $data['comprador'] }}</strong>
                </li>
            @endforeach
        </ul>

        
    </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
