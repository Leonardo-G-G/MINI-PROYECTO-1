<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gerente</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
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
                    <a href="{{ route('gerente.dashboard') }}" class="nav-link">
                        <i class="fas fa-users"></i> Usuarios
                    </a>
                </li>
            </ul>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-fluid">
            <div class="welcome-message">
                <h2>Panel del Gerente</h2>
                <p>¡Bienvenido al panel de gerente! Desde aquí podrás gestionar los usuarios y otros aspectos de la plataforma.</p>
            </div>
            
            <h2>Lista de Usuarios</h2>

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
                                    <!-- Solo habilitar el botón de edición si no es un Administrador o Gerente -->
                                    @if (!in_array($user->role, ['gerente', 'administrador']))
                                        <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    @endif
                                    <!-- No se muestra el botón de eliminar -->
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
