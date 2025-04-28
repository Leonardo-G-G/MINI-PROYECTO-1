<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style_dash.css') }}" rel="stylesheet">
</head>

<body>
    <header class="navbar navbar-dark bg-dark px-4 shadow">
        <a class="navbar-brand" href="#">Dashboard Cliente</a>
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
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-box"></i> Productos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cliente.ordenes.index') }}" class="nav-link text-white">
                        <i class="fas fa-shopping-cart"></i> Mis Órdenes
                    </a>
                </li>
            </ul>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-fluid p-4">
            <div class="welcome-message">
                <h2>Panel de Cliente</h2>
                <p>Bienvenido a tu panel de cliente. Aquí puedes ver los productos disponibles y generar órdenes.</p>
            </div>

            <!-- FORMULARIO PARA GENERAR ORDEN -->
            <h2>Generar Nueva Orden</h2>
            <form action="{{ route('cliente.ordenes.store') }}" method="POST">
                @csrf
                <table class="table table-striped table-hover shadow-sm text-center">
                    <thead class="text-white" style="background-color: #007bff;">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad Disponible</th>
                            <th>Categoría</th>
                            <th>Seleccionar</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td class="fw-bold text-success">${{ number_format($producto->precio, 2) }}</td>
                                <td class="fw-bold text-danger">{{ $producto->cantidad }}</td>
                                <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                <td>
                                    <input type="checkbox" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}">
                                </td>
                                <td>
                                    <input type="number" name="productos[{{ $producto->id }}][cantidad]" class="form-control" min="1" max="{{ $producto->cantidad }}" value="1">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Generar Orden</button>
            </form>

        </div>
    </main>
</body>
</html>
