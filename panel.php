<?php
session_start();
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ferretería</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .footer-personalizado { background-color: #343a40; }
        .banner-modern { font-family: 'Montserrat', sans-serif; }
        .banner-title { font-weight: 700; font-size: 2.2rem; line-height: 1.2; }
        .banner-title span { color: #0d6efd; }
        .banner-text { color: #6c757d; font-size: 0.95rem; max-width: 420px; }
        .btn-banner { border-radius: 50px; padding: 10px 22px; font-size: 0.85rem; }
        .section-categories { font-family: 'Montserrat', sans-serif; }
        .section-label { font-size: 0.8rem; font-weight: 600; letter-spacing: 2px; color: #6c757d; text-transform: uppercase; }
        .section-title { font-weight: 700; font-size: 1.8rem; }
        .card-title { font-weight: 600; }
        .fade-page { opacity: 0; animation: fadeInPage 2s ease-in-out forwards; }
        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .carousel.carousel-fade .carousel-item { opacity: 0; transition: opacity 1.2s ease-in-out; }
        .carousel.carousel-fade .carousel-item.active { opacity: 1; }
        .carousel.carousel-fade .carousel-item-start, .carousel.carousel-fade .carousel-item-end { transform: none; }
        .carousel-item::after { content: ""; position: absolute; inset: 0; background: rgba(0, 0, 0, 0.25); }
        .carousel-caption { opacity: 0; transform: translateY(15px); transition: all 0.8s ease; }
        .carousel-item.active .carousel-caption { opacity: 1; transform: translateY(0); }
        #carouselFerreteria { width: 100%; }
        .footer-cliente { background-color: #f3f4f6; border-top: 1px solid #e0e0e0; }
        .footer-link { color: #495057; text-decoration: none; font-weight: 500; }
        .footer-link:hover { color: #000; text-decoration: underline; }
        .home-categories-grid .cat-card{
    position: relative;
    overflow: hidden;
}

.home-categories-grid .cat-card{
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 12px 20px rgba(0,0,0,0.15);
    transition: transform .3s ease, box-shadow .3s ease;
}

.home-categories-grid .cat-card:hover{
    transform: translateY(-7px);
    box-shadow: 0 20px 30px rgba(0,0,0,0.3);
}

.home-categories-grid .cat-card img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}

.home-categories-grid .cat-card:hover img{
    transform: scale(1.06);
}

.home-categories-grid .cat-overlay{
    position: absolute;
    inset: 0;
    padding: 25px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: linear-gradient(180deg, rgba(7,12,18,0.22) 0%, rgba(3,7,12,0.65) 100%);
}

.home-categories-grid .cat-title{
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    font-size: 1.8rem;
    color: #ffffff;
    text-align: center;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.85);
    letter-spacing: 0.4px;
    line-height: 1.2;
    text-transform: capitalize;
}

/* =====================
   MODO OSCURO HOME
===================== */

body.dark-mode {
    background-color: #121212 !important;
    color: #ffffff;
}

/* Secciones con fondo claro */
body.dark-mode .footer-cliente {
    background-color: #1e1e1e !important;
    border-top: 1px solid #333;
}

/* Títulos */
body.dark-mode .section-title,
body.dark-mode .section-label {
    color: #ffffff !important;
}

/* Cards */
body.dark-mode .card {
    background-color: #1e1e1e !important;
    color: white;
}

body.dark-mode .card-text {
    color: #cccccc !important;
}

/* Botones outline */
body.dark-mode .btn-outline-dark {
    color: white;
    border-color: white;
}

body.dark-mode .btn-outline-dark:hover {
    background-color: white;
    color: black;
}

/* Overlay títulos grid */
body.dark-mode .cat-title {
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.9);
}

/* Fondo general claro de bootstrap */
body.dark-mode .bg-light {
    background-color: #121212 !important;
}

/* =====================
   BOTÓN FLOTANTE VOLVER INICIO
===================== */

.btn-volver-inicio {
    position: fixed;
    top: 30px;
    right: 30px;
    z-index: 999;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.btn-volver-inicio:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(220, 53, 69, 0.6);
    background: linear-gradient(135deg, #c82333 0%, #b01d2e 100%);
}

body.dark-mode .btn-volver-inicio {
    background: linear-gradient(135deg, #00ff88 0%, #00cc6a 100%);
    box-shadow: 0 8px 20px rgba(0, 255, 136, 0.3);
}

body.dark-mode .btn-volver-inicio:hover {
    box-shadow: 0 12px 28px rgba(0, 255, 136, 0.5);
}



    </style>
</head>

<body class="fade-page">

<?php include "navbar.php"; ?>


<div class="container my-5 banner-modern" style="background: linear-gradient(120deg, #f8fafc 60%, #e0e7ff 100%); border-radius: 24px; box-shadow: 0 8px 32px rgba(60,60,120,0.10); overflow: hidden;">
    <div class="row align-items-center g-5">
        <div class="col-md-6 position-relative">
            <img src="img/inicio.jpg" alt="Ferretería" class="img-fluid rounded-2" style="border: 6px solid #fff; box-shadow: 0 8px 32px rgba(60,60,120,0.13);">
        </div>
        <div class="col-md-6">
            <div class="d-flex align-items-center mb-3">
                <div style="width:16px;height:16px;background:#0d6efd; border-radius:4px;" class="me-2"></div>
                <strong class="fs-5 text-primary">FERRETERÍA</strong>
            </div>
            <h1 class="banner-title mb-3 animate__animated animate__fadeInDown" style="animation-delay:0.2s; font-size:2.5rem;">
                Todo para tu proyecto
            </h1>
            <p class="banner-text mb-4 animate__animated animate__fadeInUp" style="animation-delay:0.5s; font-size:1.08rem; color:#495057;">
                Somos tu ferretería de confianza en la ciudad. Encuentra herramientas, materiales y soluciones para el hogar, la construcción y la industria, con atención personalizada y productos de calidad.
            </p>
            <a href="catalogo.php" class="btn btn-primary btn-banner shadow-lg animate__animated animate__pulse animate__infinite" style="font-size:1.1rem; padding:12px 36px; font-weight:600; letter-spacing:0.5px;">
                Ver catálogo
            </a>
        </div>
    </div>
</div>

<!-- Animaciones Animate.css CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .text-gradient {
        background: linear-gradient(90deg, #0d6efd 30%, #00c6ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }
</style>

<hr class="mb-4">




<!-- SECCIÓN CATEGORÍAS -->
<div class="container mt-5 section-categories"> 
    <div class="mb-4 text-center">
        <div class="section-label">Categorias De</div>
        <div class="section-title text-dark">Nuestros Mejores Productos</div>
    </div>

    <div class="position-relative">
        <!-- Flechas -->
        <button class="btn btn-dark position-absolute top-50 start-0 translate-middle-y z-2"
                style="border-radius:0; width:40px; height:40px;"
                onclick="document.getElementById('cards-row').scrollBy({left: -300, behavior: 'smooth'})">&#8592;</button>
        <button class="btn btn-dark position-absolute top-50 end-0 translate-middle-y z-2"
                style="border-radius:0; width:40px; height:40px;"
                onclick="document.getElementById('cards-row').scrollBy({left: 300, behavior: 'smooth'})">&#8594;</button>

        <div id="cards-row" class="d-flex overflow-hidden gap-4 pb-3">
            <!-- Cards corregidas -->
            <div class="card text-center border-0 shadow-sm" style="flex: 0 0 250px; border-radius:0;">
                <img src="img/cajaa_herramientas.jpg" class="card-img-top" style="height:220px; object-fit:cover; border-radius:0;">
                <div class="card-body">
                    <h5 class="card-title">Herramientas</h5>
                    <p class="card-text text-muted">Todo lo que necesitas para tu taller</p>
                    <a href="herramientas.php" class="btn btn-outline-dark w-100" style="border-radius:0;">Ver</a>
                </div>
            </div>

            <div class="card text-center border-0 shadow-sm" style="flex: 0 0 250px; border-radius:0;">
                <img src="img/electricos.png" class="card-img-top" style="height:220px; object-fit:cover; border-radius:0;">
                <div class="card-body">
                    <h5 class="card-title">Eléctricos</h5>
                    <p class="card-text text-muted">Todo para instalaciones seguras</p>
                    <a href="electricos.php" class="btn btn-outline-dark w-100" style="border-radius:0;">Ver</a>
                </div>
            </div>

            <div class="card text-center border-0 shadow-sm" style="flex: 0 0 250px; border-radius:0;">
                <img src="img/plomeria.webp" class="card-img-top" style="height:220px; object-fit:cover; border-radius:0;">
                <div class="card-body">
                    <h5 class="card-title">Plomería</h5>
                    <p class="card-text text-muted">Soluciones para agua y desagüe</p>
                    <a href="plomeria.php" class="btn btn-outline-dark w-100" style="border-radius:0;">Ver</a>
                </div>
            </div>

            <div class="card text-center border-0 shadow-sm" style="flex: 0 0 250px; border-radius:0;">
                <img src="img/construccion.png" class="card-img-top" style="height:220px; object-fit:cover; border-radius:0;">
                <div class="card-body">
                    <h5 class="card-title">Construcción</h5>
                    <p class="card-text text-muted">Materiales resistentes para tus proyectos</p>
                    <a href="construccion.php" class="btn btn-outline-dark w-100" style="border-radius:0;">Ver</a>
                </div>
            </div>

            <div class="card text-center border-0 shadow-sm" style="flex: 0 0 250px; border-radius:0;">
                <img src="img/pinturas.png" class="card-img-top" style="height:220px; object-fit:cover; border-radius:0;">
                <div class="card-body">
                    <h5 class="card-title">Pintura</h5>
                    <p class="card-text text-muted">Colores y acabados para tus proyectos</p>
                    <a href="pintura.php" class="btn btn-outline-dark w-100" style="border-radius:0;">Ver</a>
                </div>
            </div>

            <div class="card text-center border-0 shadow-sm" style="flex: 0 0 250px; border-radius:0;">
                <img src="img/jardineria.png" class="card-img-top" style="height:220px; object-fit:cover; border-radius:0;">
                <div class="card-body">
                    <h5 class="card-title">Jardinería</h5>
                    <p class="card-text text-muted">Herramientas y accesorios para tu jardín</p>
                    <a href="jardineria.php" class="btn btn-outline-dark w-100" style="border-radius:0;">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECCIÓN DESTACADA TIPO TIENDA -->
<div class="container my-5 home-categories-grid">

    <div class="row g-4">

        <!-- Card grande izquierda -->
        <div class="col-md-6">
            <div class="cat-card" style="height: 425px;">
                <img src="img/ferreteria.png" alt="Ferretería">
                <div class="cat-overlay">
                    <div class="cat-title">Todas las variedades para tu hogar a tu gusto</div>
                    
                </div>
            </div>
        </div>

        <!-- Cards derecha -->
        <div class="col-md-6">
            <div class="row g-4">

                <div class="col-6">
                    <div class="cat-card" style="height:200px;">
                        <img src="img/baños1.png">
                        <div class="cat-overlay">
                            <div class="cat-title">Baños</div>
                            <a href="baños.php" class="btn btn-light btn-sm mt-2">Ver más</a>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="cat-card" style="height:200px;">
                        <img src="img/cocina1.png">
                        <div class="cat-overlay">
                            <div class="cat-title">Cocina</div>
                            <a href="cocina.php" class="btn btn-light btn-sm mt-2">Ver más</a>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="cat-card" style="height:200px;">
                        <img src="img/herramientas1.jpg">
                        <div class="cat-overlay">
                            <div class="cat-title">Herramientas</div>
                            <a href="herramientas.php" class="btn btn-light btn-sm mt-2">Ver más</a>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="cat-card" style="height:200px;">
                        <img src="img/s4.png">
                        <div class="cat-overlay">
                            <div class="cat-title">Electrodomésticos</div>
                            <a href="electrodomesticos.php" class="btn btn-light btn-sm mt-2">Ver más</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- SECCIÓN CARRUSEL -->
<div class="container-fluid my-5 px-0">
    <div class="text-center mb-4">
        <div class="fw-bold text-uppercase text-primary">Destacados</div>
        <h2 class="text-dark">Promociones y Novedades</h2>
    </div>

    <div id="carouselFerreteria" 
         class="carousel slide carousel-fade shadow rounded overflow-hidden"
         data-bs-ride="carousel"
         data-bs-interval="3000">

        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselFerreteria" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselFerreteria" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselFerreteria" data-bs-slide-to="2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="img/c3.jpg" 
                     class="d-block w-100" 
                     style="height:420px; object-fit:cover;" 
                     alt="Herramientas">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                    <h5>Herramientas Profesionales</h5>
                    <p>Calidad y resistencia para cada proyecto.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/c2.jpg" 
                     class="d-block w-100" 
                     style="height:420px; object-fit:cover;" 
                     alt="Construcción">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                    <h5>Materiales de Construcción</h5>
                    <p>Todo lo que necesitas en un solo lugar.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/c1.jpg" 
                     class="d-block w-100" 
                     style="height:420px; object-fit:cover;" 
                     alt="Pinturas">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                    <h5>Pinturas y Acabados</h5>
                    <p>Dale vida a tus espacios.</p>
                </div>
            </div>

        </div>

        <!-- Controles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFerreteria" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselFerreteria" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</div>

<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<?php include "footer.php"; ?>