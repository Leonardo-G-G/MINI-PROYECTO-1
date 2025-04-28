<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Editar Producto: {{ $producto->nombre }}</h1>
        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="{{ $producto->nombre }}" required>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" value="{{ $producto->precio }}" required>

            <!-- Descripción del Producto con estilo personalizado -->
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
                    onblur="this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#ced4da'">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" value="{{ $producto->cantidad }}" required min="1">

            <label for="categoria_id">Categoría:</label>
            <select name="categoria_id" id="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Actualizar Producto</button>
        </form>
        <a href="{{ route('admin.productos.index') }}">Volver</a>
    </div>
</body>
</html>
