<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendedor</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style_dash.css') }}" rel="stylesheet">
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
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-box"></i> Mis Productos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('vendedor.productos.create') }}" class="nav-link text-white">
                        <i class="fas fa-plus-circle"></i> Agregar Producto
                    </a>
                </li>
            </ul>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-fluid p-4">
            <div class="welcome-message">
                <h2>Panel de Vendedor</h2>
                <p>Aquí puedes administrar los productos que tienes en venta.</p>
            </div>

            <!-- LISTADO DE PRODUCTOS -->
            <h2>Mis Productos Registrados</h2>
            <table class="table table-striped table-hover shadow-sm text-center align-middle">
                <thead class="text-white" style="background-color: #007bff;">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>

                            <td>
                                @if ($producto->foto)
                                    <img src="{{ asset('storage/' . $producto->foto) }}"
                                         alt="Imagen del producto"
                                         width="60" height="60"
                                         style="object-fit: cover; border-radius: 5px;">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>

                            <td>{{ $producto->nombre }}</td>
                            <td class="fw-bold text-success">${{ number_format($producto->precio, 2) }}</td>
                            <td class="fw-bold text-primary">{{ $producto->cantidad }}</td>
                            <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td>{{ ucfirst($producto->estado) }}</td>
                            <td>
                                <a href="{{ route('vendedor.productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('vendedor.productos.destroy', $producto) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No tienes productos registrados aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
