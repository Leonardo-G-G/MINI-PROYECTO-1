<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/style_dash.css') }}" rel="stylesheet">
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
                    <a href="{{ route('admin.usuarios.index') }}" class="nav-link active">
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
                    <a href="{{ route('admin.estadisticas') }}" class="nav-link">
                        <i class="fas fa-chart-bar"></i> Estadísticas
                    </a>
                </li>
            </ul>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-fluid">
            <div class="welcome-message">
                <h2>Panel de Administración</h2>
                <p>¡Bienvenido al panel de administración! Desde aquí podrás gestionar todo el contenido de tu plataforma.</p>
            </div>

            <h2>Lista de Usuarios</h2>
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary mb-4">
                <i class="fas fa-user-plus"></i> Crear Nuevo Usuario
            </a>

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

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
                                    <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
