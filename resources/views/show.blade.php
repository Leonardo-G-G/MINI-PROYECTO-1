<!-- resources/views/cliente/ordenes/show.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Orden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Detalles de la Orden</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orden->productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>${{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-primary">Volver</a>

    </div>
</body>

</html>
