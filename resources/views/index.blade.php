<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salud Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Tipografía Poppins -->
    <link href="{{ asset('css/style_index.css') }}" rel="stylesheet">   
</head>
<body>
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-white shadow">
        <div class="col-md-3 mb-2 mb-md-0">
            <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                <!-- Cambié el logo a la imagen almacenada en public -->
                <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="logo me-2">
            </a>
        </div>
        <div class="col-md-3 text-end">
            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
        </div>
    </header>

    <section class="hero">
        <h1>Bienvenido a Salud Digital</h1>
        <p>Tu salud es nuestra prioridad, encuentra los mejores productos de forma rápida y confiable.</p>
    </section>

    <section class="section bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Quiénes Somos</h2>
            <p class="text-center">
                Salud Digital es una farmacia enfocada en la venta de medicamentos y productos para el cuidado de la salud a través de una plataforma digital. Ofrecemos un servicio confiable, con un catálogo amplio de medicamentos de calidad y entregas rápidas.
            </p>
            <p class="text-center">
                Nos comprometemos con la seguridad y accesibilidad de nuestros clientes, garantizando productos certificados y un proceso de compra eficiente.
            </p>
        </div>
    </section>

    <footer class="bg-dark text-light text-center py-3 mt-5">
        <p>&copy; 2025 Salud Digital. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>