<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Editar Usuario: {{ $user->name }}</h1>
        <form action="{{ route('admin.usuarios.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" required>

            <label for="password">Nueva Contraseña (Opcional):</label>
            <input type="password" name="password" id="password" minlength="8">

            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation">

            <label for="role">Rol:</label>
            <select name="role" id="role" onchange="toggleTipoCliente()">
                <option value="gerente" {{ $user->role == 'gerente' ? 'selected' : '' }}>Gerente</option>
                <option value="administrador" {{ $user->role == 'administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="cliente" {{ $user->role == 'cliente' ? 'selected' : '' }}>Cliente</option>
            </select>

            {{-- Campo tipo_cliente visible solo si el rol es cliente --}}
            <div id="tipo_cliente_container" style="display: none;">
                <label for="tipo_cliente">Tipo de Cliente:</label>
                <select name="tipo_cliente" id="tipo_cliente">
                    <option value="vendedor" {{ $user->tipo_cliente == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                    <option value="comprador" {{ $user->tipo_cliente == 'comprador' ? 'selected' : '' }}>Comprador</option>
                </select>
            </div>

            <button type="submit">Actualizar Usuario</button>
        </form>
        <a href="{{ route('admin.usuarios.index') }}">Volver</a>
    </div>

    <script>
        function toggleTipoCliente() {
            const role = document.getElementById('role').value;
            const tipoClienteContainer = document.getElementById('tipo_cliente_container');
            tipoClienteContainer.style.display = (role === 'cliente') ? 'block' : 'none';
        }

        // Ejecutar al cargar la página por si el rol es cliente
        window.onload = toggleTipoCliente;
    </script>
</body>
</html>
