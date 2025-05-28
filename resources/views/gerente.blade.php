<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gerente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style_dash.css') }}" rel="stylesheet">
</head>
<body>
<header class="navbar navbar-dark bg-dark px-4 shadow">
    <a class="navbar-brand" href="#">Dashboard Gerente</a>
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
                <a href="{{ route('gerente.dashboard') }}" class="nav-link active">
                    <i class="fas fa-users"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ventas.index') }}" class="nav-link">
                    <i class="fas fa-shopping-cart"></i> Ventas
                </a>
            </li>
        </ul>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container-fluid mt-4">
        
        {{-- MENSAJE DE ÉXITO --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERRORES DE VALIDACIÓN (opcional) --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Se encontraron los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="welcome-message mb-4">
            <h2>Panel del Gerente</h2>
            <p>¡Bienvenido al panel de gerente! Desde aquí podrás gestionar los usuarios y otros aspectos de la plataforma.</p>
        </div>

        <h2>Lista de Usuarios</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @if (!in_array($user->role, ['gerente', 'administrador']))
                                    <a href="{{ route('gerente.usuarios.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
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
