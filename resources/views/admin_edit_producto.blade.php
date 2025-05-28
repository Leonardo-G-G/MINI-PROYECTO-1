<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Admin</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body { background: #f2f4f8; font-family: 'Segoe UI', sans-serif; }
        .form-container {
            max-width: 900px; margin: auto; background: #fff;
            padding: 40px; border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-header { border-left: 5px solid #ffc107; padding-left: 15px; margin-bottom: 30px; }
        .select2-container .select2-selection--multiple {
            min-height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="form-container">
        <div class="form-header">
            <h2 class="mb-0">Editar Producto</h2>
            <p class="text-muted">Actualice la información del producto.</p>
        </div>

        <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre del libro</label>
                    <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Autor</label>
                    <input type="text" class="form-control" name="autor" value="{{ $producto->autor }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Editorial</label>
                    <input type="text" class="form-control" name="editorial" value="{{ $producto->editorial }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Número de páginas</label>
                    <input type="number" class="form-control" name="numero_paginas" value="{{ $producto->numero_paginas }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select class="form-select" name="estado" required>
                        <option value="Nuevo" {{ $producto->estado == 'Nuevo' ? 'selected' : '' }}>Nuevo</option>
                        <option value="Seminuevo" {{ $producto->estado == 'Seminuevo' ? 'selected' : '' }}>Seminuevo</option>
                        <option value="Usado" {{ $producto->estado == 'Usado' ? 'selected' : '' }}>Usado</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Año de publicación</label>
                    <input type="number" class="form-control" name="anio_publicacion" value="{{ $producto->anio_publicacion }}" min="1900" max="{{ date('Y') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="4" required>{{ $producto->descripcion }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Precio</label>
                    <input type="number" class="form-control" name="precio" value="{{ $producto->precio }}" step="0.01" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" value="{{ $producto->cantidad }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Categorías</label>
                    <select class="form-select select2" name="categoria_ids[]" multiple required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $producto->categorias->contains($categoria->id) ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Actualizar imagen</label>
                    <input type="file" class="form-control" name="foto" accept="image/*">
                    @if ($producto->foto)
                        <img src="{{ asset('storage/' . $producto->foto) }}" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-warning">Actualizar</button>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Seleccione una o más categorías",
            width: '100%'
        });
    });
</script>
</body>
</html>
