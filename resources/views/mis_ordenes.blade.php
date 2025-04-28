<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Órdenes</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="navbar navbar-dark bg-dark px-4 shadow">
        <a class="navbar-brand" href="#">Mis Órdenes</a>
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-secondary">Volver</a>
    </header>

    <div class="container mt-4">
        <h2>Órdenes Realizadas</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped text-center">
            <thead class="text-white" style="background-color: #007bff;">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordenes as $orden)
                    <tr>
                        <td>{{ $orden->id }}</td>
                        <td>{{ $orden->fecha }}</td>
                        <td class="fw-bold text-success">${{ number_format($orden->total, 2) }}</td>
                        <td>
                            <a href="{{ route('cliente.ordenes.show', $orden->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
