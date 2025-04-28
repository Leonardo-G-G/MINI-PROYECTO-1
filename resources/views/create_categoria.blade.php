<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    
</head>
<body>
    <div class="container">
        <h1>Crear Nueva Categoría</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categorias.store') }}" method="POST">
            @csrf

            <!-- Nombre de la categoría -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required class="form-control" placeholder="Nombre de la categoría">
            </div>

            <!-- Descripción de la categoría -->
<div class="mb-4">
    <label for="descripcion" class="form-label fs-5">Descripción:</label>
    <textarea name="descripcion" id="descripcion" rows="6" class="form-control" placeholder="Escribe una breve descripción de la categoría" 
        style="
            resize: none; 
            min-height: 150px; 
            width: 100%; 
            max-width: 600px; 
            border-radius: 8px; 
            border: 1px solid #ced4da; 
            background-color: #f8f9fa;
            padding: 12px; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            margin: 0 auto;
        " 
        onfocus="this.style.boxShadow='0 2px 10px rgba(0, 123, 255, 0.3)'; this.style.borderColor='#007bff'" 
        onblur="this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#ced4da'">{{ old('descripcion') }}</textarea>
</div>


            <!-- Botón para guardar la categoría -->
            <button type="submit" class="btn btn-primary">Guardar Categoría</button>
        </form>

        <!-- Enlace para volver a la lista de categorías -->
        <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    <!-- Agregar el JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
