<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .producto-img {
            width: 80px;
            height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-dark bg-dark px-4 shadow mb-4 d-flex justify-content-between">
        <a class="navbar-brand" href="#">Carrito de Compras</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </header>

    <main class="container">
        <h2 class="mb-4">Productos en tu carrito</h2>

        @if(session('carrito') && count(session('carrito')) > 0)
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalGeneral = 0; @endphp
                    @foreach (session('carrito') as $item)
                        @php 
                            $subtotal = $item['precio'] * $item['cantidad']; 
                            $totalGeneral += $subtotal; 
                        @endphp
                        <tr>
                            <td>
                                @if($item['foto'])
                                    <img src="{{ asset('storage/' . $item['foto']) }}" class="producto-img rounded shadow">
                                @else
                                    <img src="https://via.placeholder.com/80x100?text=Sin+Imagen" class="producto-img rounded shadow">
                                @endif
                            </td>
                            <td><strong>{{ $item['nombre'] }}</strong></td>
                            <td>${{ number_format($item['precio'], 2) }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('carrito.eliminar', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i> Quitar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="table-secondary fw-bold">
                        <td colspan="4" class="text-end">Total general:</td>
                        <td colspan="2">${{ number_format($totalGeneral, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="text-end">
                <a href="{{ route('cliente.comprador.dashboard') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Seguir comprando
                </a>

                {{-- Formulario para subir ticket y finalizar compra --}}
                <form action="{{ route('carrito.finalizar') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-light">
                    @csrf
                    <div class="mb-3">
                        <label for="ticket" class="form-label fw-bold">Sube tu comprobante de pago (imagen)</label>
                        <input type="file" name="ticket" id="ticket" class="form-control @error('ticket') is-invalid @enderror" accept="image/*" required>
                        @error('ticket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Finalizar compra
                    </button>
                </form>
            </div>
        @else
            <div class="alert alert-info">
                Tu carrito está vacío. <a href="{{ route('cliente.comprador.dashboard') }}">Ver productos</a>
            </div>
        @endif
    </main>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
