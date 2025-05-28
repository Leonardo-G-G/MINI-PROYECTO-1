<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Comprador</title>

    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .logo {
            width: 32px;
            height: 32px;
        }
        .card-img-top {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .card {
            border: none;
            border-radius: 0.5rem;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .welcome-box {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
            padding: 30px;
            border-radius: 10px;
        }
        .quantity-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
        }
        .quantity-btn {
            padding: 0.3rem 0.75rem;
        }
    </style>
</head>
<body>
<header class="navbar navbar-light bg-white px-4 shadow">
    <a href="/" class="d-flex align-items-center text-decoration-none">
        <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="BookHub Logo" class="logo me-2" />
        <span class="fs-4 fw-bold text-primary">BookHub</span>
    </a>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('carrito.index') }}" class="btn btn-outline-dark position-relative">
            <i class="fas fa-shopping-cart"></i>
            @php
                $carrito = session('carrito', []);
                $total = array_sum(array_column($carrito, 'cantidad'));
            @endphp
            @if($total > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $total }}
                </span>
            @endif
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </div>
</header>

<main class="container my-4">
    <div class="welcome-box mb-4">
        <h2>¡Hola, {{ auth()->user()->name }}!</h2>
        <p>Explora y compra los mejores libros disponibles en la tienda.</p>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="mensajeExito">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filtro --}}
    <form action="{{ url()->current() }}" method="GET" class="row mb-4 g-2 align-items-end">
        <div class="col-md-5">
            <label for="buscar" class="form-label">Buscar libro</label>
            <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Nombre del libro..." value="{{ request('buscar') }}">
        </div>
        <div class="col-md-4">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select name="categoria_id" id="categoria_id" class="form-select">
                <option value="">Todas</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search me-1"></i> Buscar
            </button>
            <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-eraser me-1"></i> Limpiar
            </a>
        </div>
    </form>

    {{-- Productos --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($productos as $producto)
            <div class="col">
                <div class="card h-100">
                    @if($producto->foto)
                        <img src="{{ asset('storage/' . $producto->foto) }}" class="card-img-top" alt="Imagen del producto">
                    @else
                        <img src="https://via.placeholder.com/300x250?text=Sin+Imagen" class="card-img-top" alt="Sin imagen">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text text-muted mb-1">Autor: {{ $producto->autor }}</p>
                        <p class="card-text text-muted mb-1">Editorial: {{ $producto->editorial }}</p>
                        <p class="card-text text-muted mb-1">Páginas: {{ $producto->numero_paginas }}</p>
                        <p class="card-text text-muted mb-1">Publicado en: {{ $producto->anio_publicacion }}</p>
                        <p class="card-text text-muted mb-1">Estado: <strong>{{ ucfirst($producto->estado) }}</strong></p>
                        <p class="card-text text-muted mb-1">Stock: <strong>{{ $producto->cantidad }}</strong></p>
                        <p class="card-text text-muted mb-1">
                            Categorías:
                            <strong>
                                {{ $producto->categorias->pluck('nombre')->join(', ') ?: 'Sin categoría' }}
                            </strong>
                        </p>
                        <p class="card-text text-muted mb-1">Vendedor: <strong>{{ $producto->vendedor->name ?? 'Desconocido' }}</strong></p>
                        <p class="card-text fw-bold text-success">Precio: ${{ number_format($producto->precio, 2) }}</p>
                    </div>
                    <div class="card-footer bg-white text-center">
                        @if($producto->cantidad > 0)
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <div class="quantity-wrapper mb-2">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="modificarCantidad(this, -1)">−</button>
                                    <input type="number" name="cantidad" class="form-control quantity-input" value="1" min="1" max="{{ $producto->cantidad }}">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="modificarCantidad(this, 1)">+</button>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus me-1"></i> Agregar al carrito
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning m-0 p-2">
                                <i class="fas fa-box-open me-1"></i> Producto agotado
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p>No hay productos disponibles con los filtros actuales.</p>
            </div>
        @endforelse
    </div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const mensaje = document.getElementById('mensajeExito');
    if (mensaje) {
        setTimeout(() => {
            bootstrap.Alert.getOrCreateInstance(mensaje).close();
        }, 3000);
    }

    function modificarCantidad(btn, delta) {
        const input = btn.parentElement.querySelector('input[name="cantidad"]');
        let valor = parseInt(input.value);
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        valor = Math.min(Math.max(valor + delta, min), max);
        input.value = valor;
    }
</script>
</body>
</html>
