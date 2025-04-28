<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Crear Nuevo Producto</h1>
        <form action="{{ route('admin.productos.store') }}" method="POST">
            @csrf
            
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" required>

            <!-- Descripción del producto -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fs-5">Descripción:</label>
                <textarea name="descripcion" id="descripcion" rows="6" class="form-control" placeholder="Escribe una breve descripción del producto" 
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
                    onblur="this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#ced4da'"></textarea>
            </div>

            <label for="categoria_id">Categoría:</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>

            <button type="submit">Crear Producto</button>
        </form>
        <a href="{{ route('admin.productos.index') }}">Volver</a>
    </div>
</body>
</html>
