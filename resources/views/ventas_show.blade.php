<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Venta #{{ $venta->id }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="navbar navbar-dark bg-dark px-4 shadow">
        <a class="navbar-brand" href="#">Detalles de Venta</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </header>

    <main class="container py-4">
        <h2 class="mb-4">Venta #{{ $venta->id }}</h2>

        <div class="mb-4">
            <h5>Información del comprador</h5>
            <p><strong>Nombre:</strong> {{ $venta->comprador->name }}</p>
            <p><strong>Correo:</strong> {{ $venta->comprador->email }}</p>
        </div>

        <div class="mb-4">
            <h5>Estado de la venta</h5>
            <span class="badge bg-{{ $venta->estado == 'pendiente' ? 'warning' : ($venta->estado == 'completada' ? 'success' : 'secondary') }}">
                {{ ucfirst($venta->estado) }}
            </span>
        </div>

        <div class="mb-4">
            <h5>Productos vendidos</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($venta->productos as $producto)
                        @php
                            $cantidad = $producto->pivot->cantidad;
                            $precio = $producto->pivot->precio_unitario;
                            $subtotal = $cantidad * $precio;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $cantidad }}</td>
                            <td>${{ number_format($precio, 2) }}</td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-secondary fw-bold">
                        <td colspan="3" class="text-end">Total:</td>
                        <td>${{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h5>Ticket bancario</h5>
            @if ($venta->ticket)
                <a href="{{ route('ventas.descargar', $venta) }}" class="btn btn-outline-primary">
                    <i class="fas fa-download"></i> Descargar ticket
                </a>
            @else
                <p class="text-muted">No hay ticket disponible.</p>
            @endif
        </div>

        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Regresar a ventas
        </a>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
