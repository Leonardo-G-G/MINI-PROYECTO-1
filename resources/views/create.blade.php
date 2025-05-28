<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        #tipo_cliente_container {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Nuevo Usuario</h1>
        <form action="{{ route('admin.usuarios.store') }}" method="POST">
            @csrf

            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required minlength="8">

            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <label for="role">Rol:</label>
            <select name="role" id="role" required>
                <option value="">Selecciona un rol</option>
                <option value="gerente">Gerente</option>
                <option value="administrador">Administrador</option>
                <option value="cliente">Cliente</option>
            </select>

            <!-- Campo tipo_cliente solo visible si el rol es cliente -->
            <div id="tipo_cliente_container">
                <label for="tipo_cliente">Tipo de Cliente:</label>
                <select name="tipo_cliente" id="tipo_cliente">
                    <option value="">Selecciona tipo de cliente</option>
                    <option value="comprador">Comprador</option>
                    <option value="vendedor">Vendedor</option>
                </select>
            </div>

            <button type="submit">Crear Usuario</button>
        </form>
        <a href="{{ route('admin.usuarios.index') }}">Volver</a>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const tipoClienteContainer = document.getElementById('tipo_cliente_container');

        roleSelect.addEventListener('change', function () {
            if (this.value === 'cliente') {
                tipoClienteContainer.style.display = 'block';
            } else {
                tipoClienteContainer.style.display = 'none';
                document.getElementById('tipo_cliente').value = ''; // Limpia valor si no es cliente
            }
        });
    </script>
</body>
</html>
