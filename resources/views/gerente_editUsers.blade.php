<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Editar Cliente: {{ $user->name }}</h1>
        <form action="{{ route('gerente.usuarios.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" required>

            <label for="password">Nueva Contraseña (opcional):</label>
            <input type="password" name="password" id="password" minlength="8">

            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation">

            <label for="tipo_cliente">Tipo de Cliente:</label>
            <select name="tipo_cliente" id="tipo_cliente">
                <option value="vendedor" {{ $user->tipo_cliente == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                <option value="comprador" {{ $user->tipo_cliente == 'comprador' ? 'selected' : '' }}>Comprador</option>
            </select>

            <button type="submit">Actualizar Cliente</button>
        </form>
        <a href="{{ route('gerente.dashboard') }}">Volver</a>
    </div>
</body>
</html>
