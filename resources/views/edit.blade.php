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
        <form action="{{ route('gerente.usuarios.update', $user->id) }}" method="POST">
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
            <select name="role" id="role">
                <option value="gerente" {{ $user->role == 'gerente' ? 'selected' : '' }}>Gerente</option>
                <option value="empleado" {{ $user->role == 'empleado' ? 'selected' : '' }}>Empleado</option>
                <option value="cliente" {{ $user->role == 'cliente' ? 'selected' : '' }}>Cliente</option>
            </select>

            <button type="submit">Actualizar Usuario</button>
        </form>
        <a href="{{ route('gerente.usuarios.index') }}">Volver</a>
    </div>
</body>
</html>
