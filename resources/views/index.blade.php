<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BookHub - Marketplace de Libros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
      color: #343a40;
    }

    header {
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .logo {
      height: 50px;
      object-fit: contain;
    }

    .hero {
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      color: white;
      padding: 6rem 1rem;
      text-align: center;
      border-radius: 0 0 60% 60% / 20%;
      margin-bottom: 3rem;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .hero p {
      font-size: 1.25rem;
      max-width: 600px;
      margin: 0 auto;
    }

    .section {
      padding: 4rem 1rem;
    }

    .section-alt {
      background-color: #ffffff;
      border-radius: 2rem;
      padding: 4rem 2rem;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    }

    .card-book {
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      border: none;
      border-radius: 15px;
      transition: all 0.3s ease-in-out;
    }

    .card-book:hover {
      transform: scale(1.03);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-book img {
      border-radius: 15px 15px 0 0;
      height: 250px;
      object-fit: cover;
    }

    .btn-primary {
      background-color: #2575fc;
      border-color: #2575fc;
      border-radius: 25px;
      padding: 0.5rem 1.5rem;
    }

    .btn-outline-primary {
      border-radius: 25px;
      padding: 0.5rem 1.5rem;
    }

    .btn:hover {
      opacity: 0.9;
    }

    footer {
      background-color: #212529;
      color: #adb5bd;
      font-size: 0.9rem;
      margin-top: 4rem;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 1s ease forwards;
      opacity: 0;
    }

    @media (max-width: 767.98px) {
      .hero h1 {
        font-size: 2.2rem;
      }

      .hero p {
        font-size: 1rem;
      }

      .logo {
        height: 40px;
      }

      .section {
        padding: 2rem 1rem;
      }

      .section-alt {
        padding: 2rem 1rem;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="d-flex flex-wrap align-items-center justify-content-between py-3 px-4">
    <a href="/" class="d-flex align-items-center text-decoration-none">
      <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="BookHub Logo" class="logo me-2" />
      <span class="fs-4 fw-bold text-primary">BookHub</span>
    </a>
    <div>
      <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Iniciar sesión</a>
      <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
    </div>
  </header>

  <!-- Hero -->
  <section class="hero">
    <h1>Tu Mercado de Libros en Línea</h1>
    <p>Compra y vende libros de todas las categorías. ¡Explora miles de títulos y comparte tus favoritos!</p>
  </section>

  <!-- ¿Quiénes somos? -->
  <section class="section bg-white">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-md-5 fade-in-up text-center">
          <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Persona leyendo sin fondo" class="img-fluid" style="max-height: 300px;" />
        </div>
        <div class="col-md-7 fade-in-up">
          <h2 class="fw-bold mb-3" style="color: #131842;">¿Quiénes somos?</h2>
          <p class="text-muted mb-2">
            En <strong>BookHub</strong>, creemos que cada libro merece una segunda oportunidad. Somos un equipo apasionado por la lectura y la tecnología que decidió crear un espacio donde lectores puedan comprar, vender y compartir sus historias favoritas.
          </p>
          <p class="text-muted mb-2">
            Conectamos personas a través de los libros, fomentando una comunidad responsable, accesible y vibrante. Nos inspira la idea de que un libro que ya leíste, puede ser el próximo favorito de alguien más.
          </p>
          <p class="fw-semibold" style="color: #2575fc;">BookHub: Donde las historias continúan.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Por qué elegirnos -->
  <section class="section py-5" style="background-color: #f8f9fa;">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold" style="color: #131842;">¿Por qué elegir BookHub?</h2>

      <div id="bookhubCarousel" class="carousel slide position-relative" data-bs-ride="carousel">
        <div class="carousel-inner text-center">

          <!-- Slide 1 -->
          <div class="carousel-item active">
            <div class="p-5 shadow rounded-4 bg-white mx-auto" style="max-width: 600px;">
              <img src="https://cdn-icons-png.flaticon.com/512/2983/2983805.png" width="64" class="mb-4" alt="Variedad sin límites" />
              <h5 class="fw-semibold">Explora sin límites</h5>
              <p class="text-muted">Desde clásicos hasta lo último, encuentra lo que amas o deja que un nuevo libro te encuentre a ti.</p>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item">
            <div class="p-5 shadow rounded-4 bg-white mx-auto" style="max-width: 600px;">
              <img src="https://cdn-icons-png.flaticon.com/512/682/682055.png" width="64" class="mb-4" alt="Conexión real" />
              <h5 class="fw-semibold">Conecta a través de las páginas</h5>
              <p class="text-muted">Haz que cada libro encuentre a su próximo lector. Fácil, rápido y sin complicaciones.</p>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="carousel-item">
            <div class="p-5 shadow rounded-4 bg-white mx-auto" style="max-width: 600px;">
              <img src="https://cdn-icons-png.flaticon.com/512/1946/1946433.png" width="64" class="mb-4" alt="Revive tus libros" />
              <h5 class="fw-semibold">Dales nueva vida a tus libros</h5>
              <p class="text-muted">Cada libro guarda historias, deja que sigan inspirando a otros desde tu estantería.</p>
            </div>
          </div>

        </div>

        <!-- Controles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bookhubCarousel" data-bs-slide="prev" style="width: auto;">
          <i class="bi bi-chevron-left fs-1 text-primary"></i>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bookhubCarousel" data-bs-slide="next" style="width: auto;">
          <i class="bi bi-chevron-right fs-1 text-primary"></i>
          <span class="visually-hidden">Siguiente</span>
        </button>
      </div>
    </div>
  </section>

  <!-- CTA Vender -->
  <section class="section bg-light">
    <div class="container text-center">
      <h2 class="mb-4 fw-semibold">¿Tienes libros que ya no usas?</h2>
      <p class="mb-4">Súbelos a BookHub y gana dinero vendiéndolos a otros lectores apasionados.</p>
      <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Vender mis libros</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4">
    <div class="container">
      <p class="mb-0">&copy; 2025 BookHub. Todos los derechos reservados.</p>
      <small>Creado con pasión por amantes de los libros.</small>
    </div>
  </footer>

  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>